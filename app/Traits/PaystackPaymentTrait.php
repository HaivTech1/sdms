<?php

namespace App\Traits;

use App\Models\Fee;
use App\Models\Trip;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Student;
use App\Models\StudentTrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Traits\NotifiableParentsTrait;

trait PaystackPaymentTrait
{
    /**
     * Make a one-time payment using Paystack API.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function makeOneTimePayment(Request $request)
    {
        $callback = json_decode($request['metadata'], true);
        $data = Setting::where(['key' => 'paystack'])->first();
        $paystack = json_decode($data['value'], true);
        $secretKey = env('PAYSTACK_SECRET_KEY', $paystack['secretKey']);

        $payload = [
            'email' => $request->input('email'),
            'amount' => $request->input('amount'),
            'metadata' => $request->metadata,
            'reference' => time(),
            'currency' => $request->currency,
            'payment_type' => $request->payment_type,
            'callback_url' => route(''.$callback['callback']),
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
        ])->post('https://api.paystack.co/transaction/initialize', $payload);

        if ($response->successful()) {
            $authorizationUrl = $response['data']['authorization_url'];
            return redirect($authorizationUrl);
        } else {
            $errorMessage = $response['message'] ?? 'Network error, please try again later or contact your administrator for assistance.';
            $notification = [
                'messege' => $errorMessage,
                'alert-type' => 'error',
                'button' => 'Okay',
                'title' => 'Failed payment attempt',
            ];
            return back()->with($notification);
        }
    }

    /**
     * Handle the payment callback for one-time payment.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function paymentCallback(Request $request)
    {
        $transactionRef = $request->input('reference');
        $data = $this->verifyPayment($transactionRef);

        if ($data['status'] === 'success') {
                $type = $data['metadata']['type'];
                $student_uuid = $data['metadata']['student_uuid'];
                $author_id = $data['metadata']['author_id'];
                $amount = $data['amount'] / 100;
                $reference = $data['reference'];
                $transaction = $data['id'];
                $channel = $data['channel'];
                $student = Student::findOrFail($student_uuid);
                $name = $student->last_name. ' '. $student->first_name. ' ' . $student->other_name;

                try {
                    if ($type === 'schoolbus_service') {
                        $term_id = $data['metadata']['term_id'];
                        $period_id = $data['metadata']['period_id'];
                        $trip_id = $data['metadata']['trip_id'];
                        $trip = Trip::findOrFail($trip_id);
                        $balance = $trip->price() - $amount;
                        $ifFull = $balance != 0 ? 'partial' : 'full';

                        if ($ifFull === 'partial') {
                            $payment = Payment::wherePayment_category('schoolbus_service')
                                    ->whereStudent_uuid($student_uuid)
                                    ->whereTerm_id(term('id'))
                                    ->wherePeriod_id(period('id'))->first();
                            
                            if ($payment) {
                                $old_balance = $payment->balance;
                                $newly_paid = $payment->amount + $amount;
                                $status =  $newly_paid >= $trip->price() ? 'full' : 'partial';
                                $newBalance = $newly_paid - $trip->price();
                                
                                $payment->update([
                                    'amount'            => $payment->amount + $amount,
                                    'balance'           => $newBalance,
                                    'payment_type'      => $status,
                                ]);
                            }else{
                                 $payment = new Payment([
                                    'paid_by'  => $student->last_name . ' ' . $student->first_name . ' ' . $student->other_name,
                                    'period_id'         => $period_id,
                                    'term_id'           => $term_id,
                                    'student_uuid'      => $student_uuid,
                                    'amount'            => $amount,
                                    'balance'           => $balance,
                                    'payment_type'      => $ifFull,
                                    'payment_category'  => $type,
                                    'trans_id'          => $transaction,
                                    'ref_id'            => $reference,
                                    'channel'           => $channel,
                                    'author_id'         => $author_id,
                                ]);
                                
                                if ($payment->save()) {
                                    $newTrip = new StudentTrip([
                                        'student_id' => $student_uuid,
                                        'trip_id' => $trip_id,
                                        'payment_id' => $payment->id(),
                                        'term_id' => $term_id,
                                        'period_id' => $period_id
                                    ]);
                                    $newTrip->save();
                                }
                            }
                        }else{
                            $payment = new Payment([
                                'paid_by'  => $student->last_name . ' ' . $student->first_name . ' ' . $student->other_name,
                                'period_id'         => $period_id,
                                'term_id'           => $term_id,
                                'student_uuid'      => $student_uuid,
                                'amount'            => $amount,
                                'balance'           => $balance,
                                'payment_type'      => $ifFull,
                                'payment_category'  => $type,
                                'trans_id'          => $transaction,
                                'ref_id'            => $reference,
                                'channel'           => $channel,
                                'author_id'         => $author_id,
                            ]);
                            
                            if ($payment->save()) {
                                $newTrip = new StudentTrip([
                                    'student_id' => $student_uuid,
                                    'trip_id' => $trip_id,
                                    'payment_id' => $payment->id(),
                                    'term_id' => $term_id,
                                    'period_id' => $period_id
                                ]);
                                $newTrip->save();
                            }
                        }

                        $message = "<p>This is a confirmation that $name has successfully paid $amount for school bus service. Please visit your dashboard to print your receipt Thank you.</p>";
                        $subject = 'School Bus Payment Confirmation';
                        NotifiableParentsTrait::notifyParents($student, $message, $subject);
                    }else if($type === 'ecommerce_service'){
                        $userId = $data['metadata']['user_id'];
                    }else if($type === 'school_fees'){
                            $getFee = Fee::where([
                                'grade_id' => $student->grade_id,
                                'type' => $student->type,
                                'term_id' => term('id')
                            ])->first();    
                            $sum = 0;
                            $sum += $getFee->details->sum('price');

                            $payment = new Payment([
                                'paid_by'  => $student->last_name . ' ' . $student->first_name . ' ' . $student->other_name,
                                'amount'   => $amount,
                                'payable' => $sum,
                                'balance'   => 0,
                                'description'   => '',
                                'period_id'   => period('id'),
                                'term_id'   => term('id'),
                                'author_id'   => auth()->id(),
                                'student_uuid' => $student->id(),
                                'payment_type'      => 'full',
                                'payment_category'  => $type,
                                'trans_id'          => $transaction,
                                'ref_id'            => $reference,
                                'channel'           => $channel,
                                'author_id'         => $author_id,
                            ]);
                            $payment->save();
                            $message = "<p>This is a confirmation that $name has successfully paid $amount for tuition. Please visit your dashboard to print your receipt Thank you.</p>";
                            $subject = 'Payment Confirmation';
                            NotifiableParentsTrait::notifyParents($student, $message, $subject);
                    }
                } catch (\Throwable $th) {
                    $notification = array(
                        'messege' => $th->getMessage(),
                        'alert-type' => 'error',
                        'button' => 'Okay!',
                        'title' => 'Failed'
                    );

                    return redirect()->back()->with($notification);
                }

            $notification = ([
                'messege' => 'Payment successful!',
                'alert-type' => 'success',
                'button' => 'Okay',
                'title' => 'Payment completed',
            ]);
            
            return redirect()->back()->with($notification);
        } else {
            $notification = [
                'messege' => 'There was an error completing your payment',
                'alert-type' => 'error',
                'button' => 'Okay',
                'title' => 'Failed payment attempt',
            ];
            return back()->with($notification);
        }
    }

    /**
     * Verify the payment status using Paystack API.
     *
     * @param string $transactionRef
     * @return string|null
     */
    private function verifyPayment($transactionRef)
    {
        $data = Setting::where(['key' => 'paystack'])->first();
        $paystack = json_decode($data['value'], true);
        $secretKey = env('PAYSTACK_SECRET_KEY', $paystack['secretKey']);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
        ])->get("https://api.paystack.co/transaction/verify/{$transactionRef}");

        // Check the response status
        if ($response->successful()) {
            $data = $response['data'];
            return $data;
        } else {
            return null;
        }
    }
}