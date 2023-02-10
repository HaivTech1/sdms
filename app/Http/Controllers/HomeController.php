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

        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return view('dashboard',[
                'user' => $user,
                'session' => $session,
                'term' => $term,
                'events' => $events
            ]);
        }elseif($user->isTeacher()){
            return view('dashboard/teacher',[
                'user' => $user,
                'session' => $session,
                'term' => $term,
                'events' => $events
            ]);
        }elseif($user->isBursal()){
            return view('dashboard/bursal',[
                'user' => $user,
                'session' => $session,
                'term' => $term,
                'events' => $events
            ]);
        }elseif($user->isStudent()){
            return view('dashboard/student',[
                'user' => $user,
                'session' => $session,
                'term' => $term,
                'events' => $events,
                'session' => $session,
                'term' => $term,
                'events' => $events
            ]);
        }
    }
}
