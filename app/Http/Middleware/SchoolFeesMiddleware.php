<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Fee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolFeesMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->isStudent()) {
            $user = auth()->user();
            $gradeId = $user->student->grade_id;

            if (hasPaidFullFee($user, $gradeId)) {

                $notification = array (
                    'messege' => 'It seems you have not paid your fees. You can only have access to the page if you have paid your tuition fee for the term!',
                    'alert-type' => 'info',
                    'button' => 'Okay!',
                    'title' => 'You are owing'
                );

                return redirect()->route('student.fees')->with($notification);
            }

            return $next($request);
        }

        return $next($request);
    }
}
