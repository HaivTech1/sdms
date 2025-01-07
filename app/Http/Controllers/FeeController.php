<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Jobs\CreateFee;
use App\Models\Student;
use App\Models\FeeDetail;
use App\Traits\WhatsappMessageTrait;
use Illuminate\Http\Request;
use App\Http\Requests\FeeRequest;
use App\Models\Term;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDF;

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
        try {

            $validator = Validator::make($request->all(), [
                'grade_id' => 'required',
                'term_id' => 'required',
                'type' => 'required',
            ]);
        
            if ($validator->fails()) {
                return response()->json(['status' =>  false, 'message' => $validator->errors()->all()], 500);
            }
        
            DB::transaction(function () use ($request){
                $fee = Fee::findOrFail($request->fee_id);
                $fee->update([
                    'grade_id' => $request->grade_id,
                    'term_id' => $request->term_id,
                    'type' => $request->type
                ]);

                $addmore = $request->input('addmore');

                if(!empty($addmore)) {
                    foreach($addmore as $row) {
                        if(isset($row['id'])) {
                            $detail = FeeDetail::findOrFail($row['id']);
                            $detail->title = $row['title'];
                            $detail->price = $row['price'];
                            $detail->save();
                        } else {
                            $detail = new FeeDetail;
                            $detail->title = $row['title'];
                            $detail->price = $row['price'];
                            $detail->fee_id = $fee->id();
                            $detail->save();
                        }
                    }
                }
            });

            return response()->json([
                'status' => true,
                'message' => 'Fee updated successfully!'
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

        $pdf = PDF::loadHTML('generate.debtor_list');
        $pdf->setOptions(['isHtml5ParserEnabled' => true]);
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

        return $pdf->download('debtor_list.pdf');
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
                $watMessage .= "Your child *$name*'s school fees for *$term->title* is as follows:\\ \\";
                $watMessage .= "Outstanding balance: *₦ " . number_format($outstanding, 2) . "*\\";
                $watMessage .= "Amount: *₦ " . number_format($feeAmount, 2) . "*\\";
                $watMessage .= "Total: *₦ " . number_format($total, 2) . "*\\ \\";
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
}