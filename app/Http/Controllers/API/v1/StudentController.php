<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Scopes\HasActiveScope;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\StudentResource;
use App\Http\Resources\v1\StudentCollection;
use App\Models\Fee;
use App\Models\Grade;
use App\Models\Term;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        try {
            $grade = $request->query('grade_id');
            $search = $request->query('search');
            $page = $request->query('page', 1);
            $perPage = $request->query('per_page', 20);

            $query = Student::query();

            if ($grade) {
                $query->where('grade_id', $grade);
            }

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('other_name', 'LIKE', "%{$search}%");

                    $q->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('reg_no', 'LIKE', "%{$search}%");
                    });
                });
            }

            $data = $query->withoutGlobalScope(new HasActiveScope)
                        ->paginate($perPage, ['*'], 'page', $page);

            return (new StudentCollection($data))->response()
                ->setStatusCode(200);

        } catch (\Throwable $th) {
            info($th);
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
        }
    }

    public function single($id)
    {
        $student = Student::withoutGlobalScope(new HasActiveScope)->findOrFail($id);
        return response()->json(['status' => true, 'student' => new StudentResource($student)], 200);
    }

    public function assignStudent(Request $request)
    {
        try {
            $level = $request->level;
            $gender = $request->gender;
            $user = auth()->user();

            if ($user->isSuperAdmin() || $user->isAdmin()) {
                $studentsQuery = Student::withoutGlobalScope(new HasActiveScope)->with([
                    'grade',
                    'house',
                    'club',
                    'mother',
                    'father',
                    'guardian',
                    'subjects',
                    'payments'
                ]);
            } else {
                $grade = auth()->user()->gradeClassTeacher;
                $studentsQuery = $grade->students()->with([
                    'grade',
                    'house',
                    'club',
                    'mother',
                    'father',
                    'guardian',
                    'subjects',
                    'payments'
                ]);
            }

            $studentsQuery->when($level, function ($query, $level) {
                return $query->where('grade_id', $level);
            })->when($gender, function ($query, $gender) {
                return $query->where('gender', $gender);
            });

            $students = StudentResource::collection($studentsQuery->get());
            return response()->json(['status' => true, 'students' => $students], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
        }

    }

    public function toggleStudent(Request $request)
    {
        try {
            $studentId = $request->student_id;
            $status = $request->status;

            $student = Student::withoutGlobalScope(new HasActiveScope)->findOrFail($studentId);
            $student->update(['status' => $status === true ? 1 : 0]);
            return response()->json(['status' => true, 'message' => 'Status updated successfully!']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $student = Student::withoutGlobalScope(new HasActiveScope)->findOrFail($id);
            $student->user->delete();
            $student->delete();
            return response()->json(['status' => true, 'message' => 'Student deleted successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
        }

    }

    public function assignSubjects(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $students = $request->students;
                $subjectIds = $request->subjects;

                foreach ($students as $studentId) {
                    $student = Student::withoutGlobalScope(new HasActiveScope)->findOrFail($studentId);
                    $student->subjects()->syncWithoutDetaching($subjectIds);
                }
            });

            return response()->json([
                'status' => true,
                'message' => 'Subjects synchronized successfully for the students'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function deleteSubject($id, $student)
    {
        try {
            $subject = Subject::findOrFail($id);
            $student = Student::withoutGlobalScope(new HasActiveScope)->findOrFail($student);
            $student->subjects()->detach($subject->id());

            return response()->json(['status' => true, 'message' => 'Subject for student deleted successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function getStudentFee(Request $request)
    {
        try {
            $data = $request->all();

            $validateData = Validator::make($data, [
                'student_id' => ['required', 'regex:/^SLNP/'],
                'term' => ['required', 'in:first,second,third'],
                'grade_id' => ['required'],
            ],[
            'student_id.required' => 'Student Registration number is required.',
            'student_id.regex' => 'Student ID must start with the uppercase letters "SLNP".',
            'term.required' => 'Term is required.',
            'term.in' => 'Term must be one of: First, Second, or Third.',
            'grade_id.required' => 'Please enter the grade id from the list.',
            ]);

            if ($validateData->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validateData->errors()->first()
                ], 400);
            }

            $student = Student::with(['user'])
                ->whereHas('user', function ($query) use ($data) {
                    $query->where('reg_no', $data['student_id']);
                })
                ->first();

            if (!$student) {
                return response()->json([
                    'status' => false,
                    'message' => 'Student not found with the given ID.'
                ], 404);
            }

            $term = Term::where('title', 'like', '%' . $data['term'] . '%')->first();;
            $name = trim($student->last_name . " " . $student->first_name . " " . $student->other_name);

            $getFee = Fee::with(['grade'])->where([
                'grade_id' => $data['grade_id'],
                'type' => $student->type,
                'term_id' => $term->id,
                'status' => true
            ])->first();

            if(!$getFee) {
                return response()->json([
                    'status' => false,
                    'message' => 'No fee found for the current class yet. Please check back later.'
                ], 404);
            }

            // Build fee details list and totals
            $feeDetails = [];
            foreach (($getFee->details ?? collect()) as $detail) {
                $label = $detail->title;
                $amount = (float) ($detail->price ?? 0);
                $feeDetails[] = ['label' => $label, 'amount' => $amount];
            }

            $feeAmount = collect($feeDetails)->sum('amount');
            $outstanding = $student->outstanding !== null
                ? intval($student->outstanding['outstanding'])
                : 0;
            $total = $feeAmount + $outstanding;

            // Build WhatsApp message with breakdown
            $watMessage = "Dear Parent/Guardian,\n\n";
            $watMessage .= "Your child *$name*'s school fees for {$getFee->grade->title} - $term->title is:\n\n";

            if (!empty($feeDetails)) {
                $watMessage .= "Fee Breakdown:\n";
                foreach ($feeDetails as $item) {
                    $watMessage .= "- {$item['label']}: ₦ " . number_format($item['amount'], 2) . "\n";
                }
                $watMessage .= "\n";
            }

            $watMessage .= "Outstanding Fees: *₦ " . number_format($outstanding, 2) . "*\n";
            $watMessage .= "Fees: *₦ " . number_format($feeAmount, 2) . "*\n";
            $watMessage .= "Total Fees: *₦ " . number_format($total, 2) . "*\n\n";
            $watMessage .= "The school's account number details is below:\n";
            $watMessage .= "*Acccount Number:* 1012048635\n";
            $watMessage .= "*Bank Name:* Zenith Bank\n";
            $watMessage .= "*Account Name:* St Louis Nursery and Primary School Ondo.";

            return response()->json(["status" => true, "message" => $watMessage], 200);

        } catch (\Throwable $th) {
            info($th);
            return response()->json([
                "status" => false,
                "message" => "There was an error gettting the fee.",
                "error" => $th->getMessage(),
            ], 500);
        }
    }

    public function getClasses()
    {
        try {
            $data = Grade::whereNotIn('id', [30, 27])->where("status", true)->get();
            $classes = [];
            foreach($data as $class){
                $classes[] = [
                    "id" => $class->id,
                    "name" => $class->title
                ];
            }

            return response()->json($classes);
        } catch (\Throwable $th) {
            info($th);
            return response()->json([
                "status" => false,
                "message" => "There was an error gettting the classes.",
                "error" => $th->getMessage(),
            ], 500);
        }
    }

}