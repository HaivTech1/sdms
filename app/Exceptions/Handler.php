<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    public function register()
    {
        $this->renderable( function (NotFoundHttpException $e, $request){
            if($request->is('api/*')){
                return response()->json([
                    'error' => [
                        'message'       => 'Resource not found',
                        'type'          => 'NotFoundHttpException',
                        'code'          => '4405',
                        'link'          => 'example.com/link',
                        'status_code'   => (string)$e->getStatusCode(),
                    ],
                ], 404);
            }
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        if ($request->is('student') || $request->is('student/*')) {
            return redirect()->guest('/login/student');
        }
        return redirect()->guest(route('login'));
    }
}