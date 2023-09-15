<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Gate;

class IsClassTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->user()->can(UserPolicy::CLASSTEACHER, User::class) && !Gate::denies('student_list_access')) {
            return $next($request);
        }

        throw new HttpException(403, 'Forbidden');
    }
}