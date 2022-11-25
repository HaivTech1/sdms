<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->isSuperAdmin()) {
            return view('dashboard');
        }elseif($user->isStaff()){
            return view('dashboard/staff');
        }elseif($user->isStaff()){
            return view('dashboard/staff');
        }elseif($user->isStudent()){
            return view('dashboard/student');
        }
    }
}
