<?php

namespace App\Http\Controllers;

use App\Jobs\CreateUser;
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
        $this->dispatchSync(CreateUser::fromRequest($request));

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

    public function generatePin()
    {
        return view('manager.user.generate');
    }

    public function pins()
    {
        return view('manager.user.pins');
    }

    public function certificate()
    {
        return view('manager.user.certificate');
    }
}