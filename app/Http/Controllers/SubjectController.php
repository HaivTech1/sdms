<?php

namespace App\Http\Controllers;

use PDF;
use Dompdf\Options;
use App\Models\Student;
use App\Models\Subject;
use App\Jobs\CreateSubject;
use Illuminate\Http\Request;
use App\Exports\SubjectExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\SubjectRequest;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Check if this is an AJAX request for JSON data
        if ($request->expectsJson() || $request->ajax()) {
            $subjects = Subject::orderBy('title')->get();
            
            $data = $subjects->map(function($subject) {
                return [
                    'id' => $subject->id(),
                    'title' => $subject->title(),
                    'name' => $subject->title(), // alias for consistency
                ];
            });

            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        }

        return view('admin.subject.index'); 
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectRequest $request)
    {

        // dd($request);

        $this->dispatchSync(CreateSubject::fromRequest($request));

        $notification = array (
            'messege' => 'Subject Created successfully',
            'alert-type' => 'success',
            'button' => 'Okay!',
            'title' => 'Success'
        );

        return redirect()->back()->with($notification);
    }

    public function subjectDownloadPdf()
    {
        $subjects = Subject::where([
            'status' => 1,
        ])->get();

    $pdf = PDF::loadHTML('generate.subject_list');
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
        $pdf->loadView('generate.subject_list', ['subjects' => $subjects]);

        return $pdf->download('subject_list.pdf');
    }

    
    public function getGradeSubjects($grade_id)
    {
        try{
            $student = Student::where('grade_id', $grade_id)->first();
            $student_subjects = $student->subjects;

            $subjects = [];
            foreach($student_subjects as $value){
                $subjects[] = [
                    'id' => $value->id(),
                    'title' => $value->title(),
                ];
            }

            return response()->json([
                'status' => true,
                'subjects' => $subjects
            ], 200);
        }catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function subjectDownloadExcel(Request $request)
    {
        $subjects = $request->get('subject-selected');
        return Excel::download(new SubjectExport($subjects), 'name_class_term_session_.xlsx');
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        //
    }
}