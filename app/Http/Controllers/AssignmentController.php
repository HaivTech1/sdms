<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Jobs\CreateAssignment;
use App\Mail\SendAssignmentMail;
use Illuminate\Support\Facades\Mail;
use App\Traits\NotifiableParentsTrait;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AssignmentRequest;
use App\Policies\UserPolicy;

class AssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $assignments = auth()->user()->isTeacher() ? Assignment::whereAuthor_id(auth()->id())->paginate(20) : Assignment::paginate(20);

        return view('admin.assignment.index',[
            'grades' => Grade::all(),
            'subjects' => Subject::all(),
            'assignments'   => $assignments
        ]);
    }


    public function store(Request $request)
    {
        
        $assignment = new Assignment([
            'title' => $request->title,
            'content' => $request->content,
            'grade_id' => $request->grade_id,
            'subject_id' => $request->subject_id,
        ]);


        $assignment->authoredBy(auth()->user());

        if($request->path){
        
            $fileName = $request->path->getClientOriginalName();
            $fileMimeType = $request->path->getMimeType(); 

            $filePath = 'assignments/' . $fileName;
            $isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($request->path));

            // File URL to access the video in frontend
            $url = Storage::disk('public')->url($filePath);

            if ($isFileUploaded) {
                $assignment->type = $fileMimeType;
                $assignment->path = $filePath;
                $assignment->save();
            }
        }

        
        $assignment->save();

        $notification = array (
            'messege' => 'Assignment created successfully!',
            'alert-type' => 'success',
            'button' => 'Okay!',
            'title' => 'Success'
        );
        return redirect()->back()->with($notification) ;
     
    }

    public function downloadFile($id)
    {
        $path = Assignment::where("id", $id)->value("path");
        return Storage::download('public/'.$path);
    }

    public function show(Assignment $assignment)
    {
        $expiresAt = now()->addHours(1);
        views($assignment)->cooldown($expiresAt)->record();

        return view('admin.assignment.show',[
            'assignment' => $assignment
        ]);
    }

    public function publish(Request $request)
    {
        $assignment = Assignment::where('id', $request->assignment_id)->first();
            
        if ($assignment->status == false) {
            $assignment->update(['status' => 1]);

            $message = "<p>A new assignment has just been created by " .$assignment->author()->title(). '. ' .$assignment->author()->name(). " for " .$assignment->grade->title(). "  Please visit your childs's dashboard on " . application('website') . ' to access the assignment or download</p>';
            $subject = 'New Assignment';
            
            $class = Grade::findOrFail($assignment->grade_id);
            $students = $class->students;

            foreach ($students as $key => $value) {
                NotifiableParentsTrait::notifyParents($value, $message, $subject);
            }


            return response()->json(['status' => 'success','message' => 'Assignment Made available successfully! And email sent to parent.' ], 200);
        }else{
            $assignment->update(['status' => 0]);
            return response()->json(['status' => 'success','message' => 'Assignment is made unavailable successfully!' ], 200);
        }
    }

    public function get()
    {
        $assignments = Assignment::where('status', true)->whereGrade_id(auth()->user()->student->grade->id())->get();

        return view('admin.assignment.get',[
            'assignments' => $assignments
        ]);
    }

    public function destroy($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->delete();
        
         $notification = array (
            'messege' => 'Assignment deleted successfully!',
            'alert-type' => 'success',
            'button' => 'Okay!',
            'title' => 'Success'
        );
        return redirect()->back()->with($notification) ;
    }

    
}