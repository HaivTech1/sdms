<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\v1\UserResource;
use Illuminate\Validation\ValidationException;

class TokenAuthController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request = request();

            $request->validate(
                [
                    'email'       => 'required|email',
                    'password'    => 'required',
                ]
            );

            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages(
                    [
                        'email' => ['The provided credentials are incorrect.'],
                    ]
                );
            }

            return response()->json([
                    'status' => true,
                    'user' => new UserResource($user), 
                    'token' => $user->createToken(application('name'))->plainTextToken,
                    'message' => 'Authorization successful!'
            ], 200);
        } catch (ValidationException $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json();
    }
}