<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;
use App\Models\Term;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $session = Period::whereStatus(1)->first();
        $term = Term::whereStatus(1)->first();

        if ($user->isSuperAdmin()) {
            return view('dashboard',[
                'user' => $user
            ]);
        }elseif($user->isStaff()){
            return view('dashboard/staff',[
                'user' => $user
            ]);
        }elseif($user->isStaff()){
            return view('dashboard/staff',[
                'user' => $user
            ]);
        }elseif($user->isStudent()){
            return view('dashboard/student',[
                'user' => $user,
                'session' => $session,
                'term' => $term
            ]);
        }
    }
}
