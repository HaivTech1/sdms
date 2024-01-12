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
   
     public function handle(Request $request, Closure $next, $guard = null)
     {
        $user = Auth::guard($guard)->user();

        if ($user && $user->can(UserPolicy::ADMIN, User::class)) {
            return $next($request);
        }
 
        throw new AdminException();
     }
}