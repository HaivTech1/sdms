<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Http\Request;
use App\Exceptions\AdminException;
use App\Exceptions\LoginException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class IsAdmin
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
        if (Auth::guard($guard)->user()->can(UserPolicy::ADMIN, User::class)) {
            return $next($request);
        }

        throw new AdminException();
    }
}