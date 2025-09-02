<?php

namespace App\Http\Controllers;

use App\Http\Resources\v1\PaymentResource;
use App\Models\Fee;
use App\Models\Student;
use App\Models\FeeDetail;
use App\Traits\WhatsappMessageTrait;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Period;
use App\Models\Term;
use App\Scopes\HasActiveScope;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;
use App\Jobs\NotifyParentsJob;
use App\Jobs\SendWhatsappJob;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
class FeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'bursal']);
    }
    
    public function index()
    {
        return view('admin.fee.index');
    }

    public function create()
    {
        return view('admin.fee.create');
    }

    public function single($id)
    {
        try {
            $fee = Fee::withoutGlobalScope(HasActiveScope::class)->with(['grade', 'term', 'details'])->findOrFail($id);
            return response()->json([
                'status' => true,
                'fee' => $fee
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function list(Request $request)
    {
        try {
            $query = Fee::withoutGlobalScope(HasActiveScope::class)->with(['grade', 'term', 'details'])->orderBy('created_at', 'desc');
            $perPage = $request->input('per_page', 20);
            $page = $request->input('page', 1);

            // Filter: grade_id
            if ($request->filled('grade_id')) {
                $query->where('grade_id', $request->grade_id);
            }

            // Filter: term_id
            if ($request->filled('term_id')) {
                $query->where('term_id', $request->term_id);
            }

            // Filter: type
            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }

            $total = $query->count();
            $fees = $query->skip(($page - 1) * $perPage)->take($perPage)->get();

            return response()->json([
                'status' => true,
                'fees' => $fees,
                'total' => $total,
                'current_page' => (int) $page,
                'per_page' => (int) $perPage,
                'last_page' => ceil($total / $perPage),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function debtorList()
    {
        try {
            $data = Student::where('outstanding', '!=', null)->get();
            $debtors = [];

            foreach ($data as $value){
                $debtors[] = [
                    'student_id' => $value->id(),
                    'student_name' => $value->last_name . ' ' . $value->first_name . ' ' . $value->other_name,
                    'outstanding' => $value->outstanding,
                    'class' => $value->grade->title(),
                ];
            }

            return response()->json([
                'status' => true,
                'debtors' => $debtors
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'grade_id' => 'required',
                'term_id' => 'required',
                'addmore.*.title' => 'required',
                'addmore.*.price' => 'required',
            ]);

            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->all(),
                ], 500);
            }else{
                DB::transaction(function() use ($request) {
                    $fee = new Fee([
                        'grade_id' => $request->grade_id,
                        'term_id' => $request->term_id,
                        'type' => $request->type,
                    ]);
                    $fee->authoredBy(auth()->user());
                    $fee->save();
    
                    foreach ($request->addmore as $key => $value) {
                        $details = FeeDetail::create([
                            'fee_id' => $fee->id,
                            'title' => $value['title'],
                            'price' => $value['price'],
                        ]);
                    }
                });
            }
            return response()->json([
                'status' => true,
                'message' => 'Fee created successfully!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function deleteFee($fee, $item){
       try{
            $fee = FeeDetail::where([
                'fee_id' => $fee,
                'id' => $item
            ])->first();

            $fee->delete();

            return response()->json([
                'status' => true,
                'message' => 'Item deleted successfully from fee!',
            ], 200);

       }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
       }
    }

    public function update(Request $request)
    {
            $validator = Validator::make($request->all(), [
            'fee_id'           => ['required', 'integer', Rule::exists('fees', 'id')],
            'grade_id'         => ['required', 'integer', Rule::exists('grades', 'id')],
            'term_id'          => ['required', 'integer', Rule::exists('terms', 'id')],
            'type'             => ['required', Rule::in(['n', 's', 'scholarship', 'border'])],
            'addmore'          => ['array'],
            'addmore.*.id'     => ['nullable', 'integer', Rule::exists('fee_details', 'id')],
            'addmore.*.title'  => ['required_with:addmore.*.price', 'nullable', 'string', 'max:255'],
            'addmore.*.price'  => ['required_with:addmore.*.title', 'nullable', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        // Find the fee via request->fee_id
        $fee = Fee::findOrFail($validated['fee_id']);

        // Ensure any provided fee_detail IDs belong to this fee (ownership check)
        $incomingIds = collect($validated['addmore'] ?? [])
            ->pluck('id')->filter()->values();

        if ($incomingIds->isNotEmpty()) {
            $ownedCount = FeeDetail::where('fee_id', $fee->id)
                ->whereIn('id', $incomingIds)
                ->count();

            if ($ownedCount !== $incomingIds->count()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'One or more fee detail IDs do not belong to this fee.',
                ], 422);
            }
        }

        return DB::transaction(function () use ($fee, $validated) {
            // 1) Update the fee itself
            $fee->update(Arr::only($validated, ['grade_id', 'term_id', 'type']));

            // 2) Normalize incoming detail rows (trim, cast, timestamps)
            $rows = collect($validated['addmore'] ?? [])
                ->map(function ($r) use ($fee) {
                    $title = trim((string)($r['title'] ?? ''));
                    $price = (float)($r['price'] ?? 0);
                    return [
                        'id'         => $r['id'] ?? null,
                        'fee_id'     => $fee->id, // ✅ not $fee->id()
                        'title'      => $title,
                        'price'      => $price,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                })
                // ignore completely empty lines
                ->filter(fn ($r) => $r['title'] !== '' || $r['price'] > 0)
                ->values();

            // 3) Delete removed details (present in DB but missing from payload)
            $keepIds = $rows->pluck('id')->filter()->values()->all();
            FeeDetail::where('fee_id', $fee->id)
                ->when(!empty($keepIds), fn ($q) => $q->whereNotIn('id', $keepIds))
                ->delete();

            // 4) Upsert existing + insert new in bulk
            $existing = $rows->whereNotNull('id')->values();
            $new      = $rows->filter(fn ($r) => empty($r['id']))
                            ->map(fn ($r) => Arr::except($r, 'id'))
                            ->values();

            if ($existing->isNotEmpty()) {
                FeeDetail::upsert(
                    $existing->all(),
                    ['id'], // unique by
                    ['title', 'price', 'fee_id', 'updated_at'] // columns to update
                );
            }

            if ($new->isNotEmpty()) {
                FeeDetail::insert($new->all());
            }

            return response()->json([
                'status'  => true,
                'message' => 'Fee updated successfully!',
            ], 200);
        });
    }

    public function delete($id)
    {
        try {
            $fee = Fee::withoutGlobalScope(HasActiveScope::class)->findOrFail($id);
            $fee->delete();

            return response()->json([
                'status' => true,
                'message' => 'Fee deleted successfully!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function debtDelete($student_id)
    {
        try {
            $student = Student::findOrFail($student_id);
            $student->update([
                'outstanding' => null,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Deleted debt successfully.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => true,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function downloadDebtorListPDF()
    {
        try {
            $data = Student::whereNotNull('outstanding')->get();
            $debtors = [];

            foreach ($data as $value){
                $debtors[] = [
                    'student_id' => $value->id(),
                    'student_name' => $value->last_name . ' ' . $value->first_name . ' ' . $value->other_name,
                    'outstanding' => $value->outstanding,
                    'class' => $value->grade->title(),
                ];
            }

            $pdf = PDF::loadHTML('generate.debtor_list');
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
            $pdf->loadView('generate.debtor_list', ['debtors' => $debtors]);
            $pdfBytes = $pdf->output();
            $filename = 'outstanding-fee-' . uniqid() . '.pdf';
            $relativePath = 'receipts/' . $filename;
            Storage::put($relativePath, $pdfBytes);
            $publicUrl = asset('storage/' . $relativePath);
            // return $pdf->download('debtor_list.pdf');
            return response()->json([
                'status' => true,
                'file_path' => $publicUrl
            ]);
        } catch (\Throwable $th) {
            info($th);
             return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function updateOutstanding(Request $request)
    {
       try {
        $student = Student::findOrFail($request->get('student_id'));
        $outstandingData = $student->outstanding;
        $outstandingData['outstanding'] = $request->price;
        $student->outstanding = $outstandingData;
        $student->save();

        return response()->json([
            'status' => true,
            'message' => 'Updated successfully.'
        ], 200);
       } catch (\Throwable $th) {
            return response()->json([
                'status' => true,
                'message' => $th->getMessage(),
            ], 500);
       }
    }

    public function outstandings()
    {
        try{
            $students = Student::whereNotNull("outstanding")->get();

            $outstandings = [];
            foreach($students as $student){
                $term = Term::findOrFail($student->outstanding['term_id']);
                $period = Period::findOrFail($student->outstanding['period_id']);

                $outstandings[]= [
                    'id' => $student->uuid,
                    'name' => $student->fullName(),
                    'outstanding' => [
                        'amount' => intval($student->outstanding['outstanding']),
                        'term' => $term->title,
                        'period' => $period->title
                    ]
                ];
            }

            return response()->json([
                'status' => true,
                'outstandings' => $outstandings
            ], 200);
        }catch(\Throwable $th){
            info($th);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]. 500);
        }
    }

    public function addOutstanding(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'student_id' => ['required', 'exists:students,uuid'],
                'outstanding' => ['required', 'numeric', 'min:0'],
                'grade_id' => ['required', 'exists:grades,id'],
            ]);

            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->toArray()
                ], 400);
            }

            $student = Student::where('uuid', $data['student_id'])->first();
            $student->update([
                'outstanding' => $data,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Outstanding submitted successfully!'
            ], 201);
        } catch (\Throwable $th) {
            info($th);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 201);
        }
    }

    public function deleteOutstanding(Request $request)
    {
        try {
            $student = Student::findOrFail($request->student_id);
            $student->update([
                'outstanding' => null,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Outstanding deleted successfully!'
            ], 200);
        } catch (\Throwable $th) {
            info($th);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 201);
        }
    }

    public function notifyParents(Request $request)
    {
        try {
            // Validate request input
            $request->validate([
                'students' => 'required|array',
                'term_id' => 'required|exists:terms,id',
            ]);

            // Fetch students and term details
            $requestStudents = $request->students;
            $students = Student::whereIn('uuid', $requestStudents)->get();
            $term = Term::findOrFail($request->term_id);

            foreach ($students as $student) {
                $name = trim($student->last_name . " " . $student->first_name . " " . $student->other_name);
                $grade = $student->grade;

                $getFee = Fee::where([
                    'grade_id' => $grade->id,
                    'type' => $student->type,
                    'term_id' => $term->id,
                ])->first();

                $fee = 0; 
                if ($getFee) {
                    $fee += $getFee->details->sum('price');

                    $feeAmount = $fee;
                    $outstanding = $student->outstanding !== null
                        ? intval($student->outstanding['outstanding'])
                        : 0;

                    $total = $fee += $outstanding;
                }

                $watMessage = "Dear Parent/Guardian,\\ \\";
                $watMessage .= "Your child *$name*'s school fees for $term->title term is as follows:\\ \\";
                $watMessage .= "Outstanding Feespublic function notifyParents(Request $request)
    
        }: *₦ " . number_format($outstanding, 2) . "*\\";
                $watMessage .= "Fees: *₦ " . number_format($feeAmount, 2) . "*\\";
                $watMessage .= "Total Fees: *₦ " . number_format($total, 2) . "*\\ \\";
                $watMessage .= "The school's account number details is below:\\*Acccount Number:* 1012048635\\*Bank Name:* Zenith Bank\\*Account Name:* St Louis Nursery and Primary School Ondo.";

                WhatsappMessageTrait::sendParent($student, $watMessage);
            }

            return response()->json(["status" => true, "message" => "Parents have been successfully notified."], 200);

        } catch (\Throwable $th) {
            info($th);
            return response()->json([
                "status" => false,
                "message" => "There was an error notifying the parents.",
                "error" => $th->getMessage(),
            ], 500);
        }
    }

    public function notify($id)
    {
        try {
            return response()->json([
                'status' => true,
                'message' => 'Fee creation in progress. This may take a few minutes depending on the number of students and classes.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function toggle($id)
    {
        try {
            $fee = Fee::withoutGlobalScope(HasActiveScope::class)->findOrFail($id);
            $fee->status = !$fee->status;
            $fee->save();

            return response()->json([
                'status' => true,
                'message' => 'Fee status updated successfully.',
                'active' => $fee->status,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function payments(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 30);
            $page = $request->input('page', 1);
            $search = trim((string) $request->input("search", ""));
            $query = Payment::with(['student', 'period', 'term'])->orderBy('created_at', 'desc');

            if($search){
                $query->where(function($q) use ($search) {
                    $q->whereHas('student', function($sq) use ($search) {
                        $sq->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]) 
                           ->orWhere('last_name', 'like', "%{$search}%")
                           ->orWhere('first_name', 'like', "%{$search}%")
                           ->orWhere('uuid', $search)
                           ->orWhereHas('user', function($u) use ($search) {
                                $u->where('reg_no', 'like', "%{$search}%");
                           });
                    })
                    ->orWhere('student_uuid', $search)
                    ->orWhere('paid_by', 'like', "%{$search}%")
                    ->orWhere('trans_id', 'like', "%{$search}%")
                    ->orWhere('ref_id', 'like', "%{$search}%");
                });
            }

            if ($request->filled('grade_id')) {
                $query->where('grade_id', $request->grade_id);
            }

            // Filter: term_id
            if ($request->filled('term_id')) {
                $query->where('term_id', $request->term_id);
            }

            // Filter: type
            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }

            if ($request->filled('method')) {
                $query->where('method', $request->method);
            }

            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            $total = $query->count();
            $payments = $query->skip(($page - 1) * $perPage)->take($perPage)->get();

            return response()->json([
                'status' => true,
                'payments' => $payments,
                'total' => $total,
                'current_page' => (int) $page,
                'per_page' => (int) $perPage,
                'last_page' => ceil($total / $perPage),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function paymentDetails($id)
    {
        try {
            $payment = Payment::with(['student', 'period', 'term'])->findOrFail($id);

            return response()->json([
                'status' => true,
                'payment' => new PaymentResource($payment)
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function createPayment(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'student_uuid' => 'required|exists:students,uuid',
                'paid_by' => 'required|string|max:255',
                'amount' => 'required|numeric|min:0',
                'period_id' => 'required|exists:periods,id',
                'term_id' => 'required|exists:terms,id',
                'type' => 'required|in:full,partial',
            ]);

            if($validator->fails()){
                return response()->json(['status' => false, 'message' => $validator->errors()->toArray()], 400);
            }

            $period = Period::find($request->period_id);
            $term = Term::find($request->term_id);
            $amount = intval($request->amount);
            $balance = intval($request->balance);
            $type = $request->type;

            $student = Student::where('uuid', $request->student_uuid)->first();
            $check = Payment::where('student_uuid', $student->uuid)->where('period_id', $period->id)->where('term_id', $term->id)->first();

            $getFee = Fee::where([
                'grade_id' => $request->grade_id,
                'type' => $student->type,
                'term_id' => $term->id,
            ])->first();

            if(!$getFee){
                return response()->json([
                    'status' => false,
                    'message' => "There is no fee set yet for the given term. Please add first."
                ], 400);
            }

            $fee = 0; 
            $fee += $getFee->details->sum('price');

            $outstanding = $student->outstanding !== null
            ? intval($student->outstanding['outstanding'])
            : 0;

            $totalPayable = $fee += $outstanding;
            $feeBalance = $totalPayable - $amount;

            if ($check && $check->type === 'full') {
                return response()->json([
                        'status' => false, 
                        'message' => "{$student->fullName()} is not owing for {$period->title} - {$term->title}"
                ], 400);
            } elseif($check && $check->type === 'partial') {
                $current = $check->amount + $amount;
                $check->update(['amount' => $current, 'type' => $type, 'balance' => $balance]);
                return response()->json([
                    'status' => false,
                    'message' => "Payment updated successfully for {$student->fullName()}"
                ], 200);
            }else{
                $payment = new Payment([
                'paid_by'  => $request->paid_by,
                'initial'  => $amount,
                'payable'   => $totalPayable,
                'amount'   => $amount,
                'balance' =>  $balance ? $balance : $feeBalance,
                'method' => 'cash',
                'period_id'   => $period->id,
                'term_id'   => $term->id,
                'type'   => $type,
                'category' => $request->category,
                'student_uuid' => $student->uuid,
                'author_id' => auth()->id(),
                ]);

                $payment->trans_id = 'TRX'.rand(0000,9999);
                $payment->ref_id = 'REF'.rand(0000,9999);
                $payment->save();

                // generate PDF receipt using existing receipt blade
                try {
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
                    Storage::put($relativePath, $pdfBytes);
                    $publicUrl = asset('storage/' . $relativePath);

                    // persist receipt filename/path on the payment record
                    try {
                        $payment->receipt = $relativePath;
                        $payment->save();
                    } catch (\Throwable $e) {
                        info('Failed to save receipt path on payment: ' . $e->getMessage());
                    }

                    // dispatch notifications to parents: email (with attachment path) and whatsapp (with public URL)
                    try {
                        $subject = "Payment Receipt for " . $student->fullName();
                        $body = "Dear Parent/Guardian,\n\nPlease find attached the payment receipt for your child " . $student->fullName() . ".\n\nThank you.";

                        // NotifyParentsJob expects ($student, $body, $subject, $path = null, $eventId = null)
                        // pass the storage relative path so the job/mailable can attach by path; include eventId null
                        dispatch(new NotifyParentsJob($student, $body, $subject, storage_path('app/' . $relativePath)));

                        // SendWhatsappJob expects ($student = null, string $message, string $type = 'parent', $eventId = null)
                        $waMessage = "Payment receipt for " . $student->fullName() . ": " . $publicUrl;
                        dispatch(new SendWhatsappJob($student, $waMessage, 'parent'));
                    } catch (\Throwable $notifEx) {
                        info('Payment notifications dispatch failed: ' . $notifEx->getMessage());
                    }
                } catch (\Throwable $e) {
                    // fall back to empty receipt url if PDF generation fails
                    info('Receipt PDF generation failed: ' . $e->getMessage());
                    $publicUrl = '';
                }

                return response()->json([
                    'status' => true,
                    'message' => "Payment created successfully! for {$student->fullName()}",
                    'receipt' => $publicUrl,
                ], 201);
            }
        } catch (\Throwable $th) {
            info($th);
            return response()->json([
                'status' => false,
                'message' => "There was a problem creating the payment. Please contact the administrator or try again later.",
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function deletePayment($id)
    {
        try {
            $payment = Payment::findOrFail($id);

            if (!empty($payment->receipt) && Storage::exists($payment->receipt)) {
                Storage::delete($payment->receipt);
            }

            $payment->delete();

            return response()->json([
                'status' => true,
                'message' => 'Payment deleted successfully!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function downloadReceipt($payment)
    {
        $check = Payment::findOrFail($payment);
        if (empty($check->receipt) || !\Illuminate\Support\Facades\Storage::exists($check->receipt)) {
            abort(404);
        }

        $path = storage_path('app/' . $check->receipt);
        $name = basename($check->receipt);
        return response()->download($path, $name, [
            'Content-Type' => 'application/pdf'
        ]);
    }
}