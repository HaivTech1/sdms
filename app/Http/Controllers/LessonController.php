<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Lesson;
use App\Models\Subject;
use App\Jobs\CreateLesson;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;

class LessonController extends Controller
{
    public function __construct()
    {
        return $this->middleware(['auth']);
    }
   
    public function index()
    {
        return view('student.lesson.index');
    }

    public function create()
    {
        if(auth()->user()->isSuperAdmin() || auth()->user()->isAdmin()){
            $lessons = Lesson::paginate(5);
        }elseif(auth()->user()->isTeacher()) {
            $lessons = Lesson::where('author_id', auth()->id())->paginate(5);
        }

        return view('admin.lesson.create',[
            'grades' => Grade::all(),
            'subjects' => Subject::all(),
            'lessons' => $lessons
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLessonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLessonRequest $request)
    {
        $lesson = new Lesson([
            'title' => $request->title,
            'description' => $request->description,
            'grade_id' => $request->grade_id,
            'subject_id' => $request->subject_id,
        ]);


        $fileName = $request->video->getClientOriginalName();
        $filePath = 'videos/' . $fileName;
        $fileMimeType = $request->video->getMimeType(); 
        $isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($request->video));
        // File URL to access the video in frontend
        // $url = Storage::disk('public')->url($filePath);

        if ($isFileUploaded) {
            $lesson->type = $fileMimeType;
            $lesson->path = $filePath;
        }

        $coverFileName = $request->cover->getClientOriginalName();
        $coverFilePath = 'cover/' . $coverFileName;
        $coverIsFileUploaded = Storage::disk('public')->put($coverFilePath, file_get_contents($request->cover));
        if ($coverIsFileUploaded) {
            $lesson->cover = $coverFilePath;
        }

        if($request->transcript){
            $transcriptFileName = $request->transcript->getClientOriginalName();
            $transcriptFilePath = 'transcript/' . $transcriptFileName;
            $transcriptIsFileUploaded = Storage::disk('public')->put($transcriptFilePath, file_get_contents($request->transcript));
            $lesson->transcript = $transcriptFilePath;
        }

        $lesson->authoredBy(auth()->user());
        $lesson->save();

        $notification = array (
            'messege' => 'Lesson created successfully!',
            'alert-type' => 'success',
            'button' => 'Okay!',
            'title' => 'Success'
        );
        return redirect()->back()->with($notification);
    }

   
    public function show(Lesson $lesson)
    {
        $expiresAt = now()->addHours(1);
        views($lesson)->cooldown($expiresAt)->record();
        
        return view('student.lesson.show', compact('lesson'));
    }

    public function destroy($id)
    {
       $lesson = Lesson::findOrFail($id);
       File::delete(storage_path('app/' . $lesson->cover()));
       File::delete(storage_path('app/' . $lesson->path));
       $lesson->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Record deleted successfully!'
        ]);
    }

    public function downloadFile($id)
    {
        $path = Lesson::where("id", $id)->value("transcript");
        return Storage::download('public/'.$path);
    }
}
