<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Term;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\TermResource;
use App\Http\Resources\v1\GradeResource;
use App\Http\Resources\v1\SessionResource;
use App\Http\Resources\v1\SettingResource;

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
}