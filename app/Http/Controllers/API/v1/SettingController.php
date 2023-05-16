<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Subject;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\TermResource;
use App\Http\Resources\v1\GradeResource;
use App\Http\Resources\v1\SessionResource;
use App\Http\Resources\v1\SettingResource;
use App\Http\Resources\v1\SubjectResource;

class SettingController extends Controller
{
    public function index()
    {
        $application = new SettingResource(Application::first());

        try {
            return response()->json(['status' => true, 'settings' => $application], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
        }
    }

    public function grade()
    {
        $data = Grade::all();
        $grades  = GradeResource::collection($data);
        return response()->json(['status' => 200, 'grades' => $grades], 200);
    }

    public function session()
    {
        $data = Period::all();
        $sessions  = SessionResource::collection($data);
        return response()->json(['status' => 200, 'sessions' => $sessions], 200);
    }

    public function term()
    {
        $data = Term::all();
        $terms  = TermResource::collection($data);
        return response()->json(['status' => 200, 'terms' => $terms], 200);
    }

    public function subject()
    {
        $data = Subject::all();
        $subjects  = SubjectResource::collection($data);
        return response()->json(['status' => 200, 'subjects' => $subjects], 200);
    }

    public function midtermFormat()
    {
        try{
            $midterm = get_settings('midterm_format');
            return response()->json(['midterm' => $midterm], 200);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function examFormat()
    {
        try {
            $exam = get_settings('exam_format');
            return response()->json(['exam' => $exam], 200);
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
