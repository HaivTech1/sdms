<?php

namespace App\Http\Controllers;

use App\Jobs\CreateUSer;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Resources\v1\UserResource;


class UserController extends Controller
{
    public function index()
    {
        return view('manager.user.index');
    }

    public function create()
    {
        return view('manager.user.create');
    }

    
    public function store(UserRequest $request)
    {
        $this->dispatchSync(CreateUSer::fromRequest($request));

        $notification = array(
            'messege' => 'User created successfully',
            'alert-type' => 'success',
            'title' => 'Successful!',
            'button' => 'Thanks, operation successful!',
        );
        
        return redirect()->route('user.index')->with($notification);
    }

    public function me()
    {
        return new UserResource(auth()->user());
    }
}