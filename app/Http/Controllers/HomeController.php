<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;
use App\Models\Term;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $session = Period::whereStatus(1)->first();
        $term = Term::whereStatus(1)->first();

        $events = Event::where('category', 'bg-info')->get();

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
                'term' => $term,
                'events' => $events
            ]);
        }
    }
}
