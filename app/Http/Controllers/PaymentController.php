<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Events\Student\PaymentEvent;
use App\Http\Resources\v1\PaymentResource;
use App\Jobs\NotifyParentsJob;
use App\Jobs\SendWhatsappJob;
use App\Models\Term;
use App\Traits\NotifiableParentsTrait;
use App\Traits\PaystackPaymentTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{

    use PaystackPaymentTrait;
    
     public function makePayment(Request $request)
    {
        return $this->makeOneTimePayment($request);
    }

    public function callback(Request $request)
    {
        return $this->paymentCallback($request);
    }
    
    public function receipt($payment)
    {
        $check = Payment::findOrFail($payment);
        return view('student.receipt',[
            'payment' => $check
        ]);
    }

    public function getStudents(Request $request)
    {
        $email = $request->input('email');

        $students = Student::whereHas('mother', function ($query) use ($email) {
            $query->where('email', $email);
        })->orWhereHas('father', function ($query) use ($email) {
            $query->where('email', $email);
        })->get();

        return response()->json($students);
    }

    public function paystackWebhook(Request $request)
    {
        // Use the raw body when verifying signature
        $raw = $request->getContent();
        $payload = $request->all();

        // Verify the webhook signature
        $signature = $request->header('x-paystack-signature');
        $secret = get_settings('paystackSecretKey');
        $computedSignature = hash_hmac('sha512', $raw, $secret);

        if (! $signature || $signature !== $computedSignature) {
            Log::warning('Paystack webhook signature mismatch.', ['header' => $signature]);
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        // Process the webhook event
        if (isset($payload['event']) && $payload['event'] === 'charge.success') {
            $data = $payload['data'] ?? [];
            Log::info('Paystack charge.success webhook received', ['data' => $data]);

            $metadata = $data['metadata'] ?? [];
            $type = $metadata['type'] ?? null;
            $student_uuid = $metadata['student_uuid'] ?? null;
            $term = Term::where('title', 'like', '%' . ($metadata['term'] ?? '') . '%')
            ->first()?->id;
            $grade_id = $metadata['grade_id'] ?? null;

            $amount = isset($data['amount']) ? ($data['amount'] / 100) : 0;
            $reference = $data['reference'] ?? null;
            $transaction = $data['id'] ?? null;
            $channel = $data['channel'] ?? null;

            // Basic validation
            if (! $reference || ! $transaction) {
                Log::warning('Paystack webhook missing reference/transaction.', ['data' => $data]);
                return response()->json(['message' => 'Invalid payload'], 400);
            }

            // Idempotency: do nothing if we already recorded this payment
            $existing = Payment::where('ref_id', $reference)
                ->orWhere('trans_id', $transaction)
                ->first();

            if ($existing) {
                Log::info('Paystack webhook skipped: payment already exists', ['ref' => $reference, 'trans' => $transaction]);
                return response()->json(['message' => 'Already processed'], 200);
            }

            try {
                // Find student by uuid (Student primary key is uuid)
                $student = null;
                if ($student_uuid) {
                    $student = Student::where('uuid', $student_uuid)->first();
                }

                if (! $student) {
                    Log::error('Paystack webhook cannot find student', ['student_uuid' => $student_uuid]);
                    // Return OK so Paystack doesn't retry endlessly; we logged the issue for manual handling
                    return response()->json(['message' => 'Student not found'], 200);
                }

                $userId = $student->user->id() ?? null;

                // Find applicable fee; fall back gracefully
                $getFee = Fee::where([
                    'grade_id' => $grade_id,
                    'type' => $student->type,
                    'term_id' => $term
                ])->first();

                $outstanding = $student->outstanding !== null
                ? intval($student->outstanding['outstanding'])
                : 0;


                $sum = 0;
                if ($getFee && isset($getFee->details)) {
                    $sum = $getFee->details->sum('price');
                }

                $total = $sum + $outstanding;

                $name = $student->fullName();

                $payment = new Payment();
                $payment->paid_by = $name;
                $payment->amount = $amount;
                $payment->payable = $total;
                $payment->balance = max(0, $total - $amount);
                $payment->period_id = period('id');
                $payment->term_id = $term;
                $payment->author_id = $userId;
                $payment->student_uuid = $student_uuid;
                $payment->type = 'full';
                $payment->category = $type ?: 'unknown';
                $payment->trans_id = $transaction;
                $payment->ref_id = $reference;
                $payment->method = $channel ?: null;
                $payment->save();

                $pdf = Pdf::loadView('student.receipt', ['payment' => $payment, 'student' => $student]);
                    $options = new Options();
                    $options->set('isHtml5ParserEnabled', true);
                    $pdf->getDomPDF()->setOptions($options);
                    $pdf->setPaper('a4', 'portrait');
                    $pdf->setWarnings(false);
                    $pdf->getDomPDF()->setHttpContext(
                        stream_context_create([
                            'ssl' => [
                                'allow_self_signed' => true,
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                            ],
                        ])
                    );

                    $pdfBytes = $pdf->output();
                    $filename = 'receipt-' . $payment->id . '-' . uniqid() . '.pdf';
                    $relativePath = 'receipts/' . $filename;

                    Storage::disk('public')->put($relativePath, $pdfBytes, [
                    'visibility' => 'public',
                    'ContentType' => 'application/pdf',
                    ]);

                    $publicUrl = asset('storage/' . $relativePath);
                    $payment->update(['receipt' => $relativePath]);

                    try {
                        $subject = "Payment Receipt for " . $name;
                        $body = "Dear Parent/Guardian,\n\nPlease find attached the payment receipt for your child " . $name . ".\n\nThank you.";
                        dispatch(new NotifyParentsJob($student, $body, $subject, storage_path('app/' . $relativePath)));
                        $waMessage = "Payment receipt for " . $name . ": " . $publicUrl;
                        dispatch(new SendWhatsappJob($student, $waMessage, 'parent'));
                    } catch (\Throwable $notifEx) {
                        info('Payment notifications dispatch failed: ' . $notifEx->getMessage());
                    }

            } catch (\Throwable $th) {
                Log::error('Error processing Paystack webhook: ' . $th->getMessage(), ['trace' => $th->getTraceAsString()]);
                return response()->json(['message' => 'Processed with warnings'], 200);
            }
        }

        return response()->json(['message' => 'Webhook received'], 200);
    }

    public function verifyPayment($transactionRef)
    {
        try {
            
            $secretKey = get_settings('paystackSecretKey');

            if (! $secretKey) {
                Log::error('Paystack verify attempted without secret key configured.');
                return [
                    'status' => 'error',
                    'message' => 'Verification failed: secret key not configured',
                ];
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $secretKey,
            ])->get("https://api.paystack.co/transaction/verify/{$transactionRef}");

            $json = $response->json();

            if ($response->successful() && isset($json['data'])) {
                return response()->json([
                    'status' => 'success',
                    'data' => $json['data'],
                ]);
            }

            Log::warning('Paystack verify returned non-success', ['ref' => $transactionRef, 'status' => $response->status(), 'body' => $response->body()]);

            return [
                'status' => 'error',
                'message' => $json['message'] ?? 'verification failed',
                'raw' => $json,
            ];

        } catch (\Throwable $e) {
            Log::error('Exception while verifying Paystack transaction: ' . $e->getMessage(), ['ref' => $transactionRef]);
            return [
                'status' => 'error',
                'message' => 'exception',
                'error' => $e->getMessage(),
            ];
        }
    }

    public function studentPaymentHistory(Request $request)
    {
        try {
            $user = $request->user();
            if (! $user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized',
                ], 401);
            }

            $student = Student::where('user_id', $user->id())->first();
            if (! $student) {
                return response()->json([
                    'status' => false,
                    'message' => 'Student record not found',
                ], 404);
            }

            $payments = Payment::with(['period', 'term'])->where('student_uuid', $student->uuid)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => true,
                'payments' => new PaymentResource($payments),
            ]);
        } catch (\Throwable $th) {
            info($th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching payment history',    
            ]);
        }
    }
}