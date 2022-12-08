<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:student')->except('logout');
    }

    public function showLoginForm(){
      if(User::first()){
        if (Application::notSet()) {
          return view('setup');
        } else {
          return view('auth.login');
        }
      } else {
        return Redirect()->route('setupUser');
      }
    }

    public function showStudentLoginForm()
    {
      if(User::first()){
        if (Application::notSet()) {
          return view('setup');
        } else {
          return view('auth.login', ['url' => 'student']);
        }
      } else {
        return Redirect()->route('setupUser');
      }
    }

    public function studentLogin(Request $request)
    {
        $this->validate($request, [
            'reg_no'   => 'required',
            'password' => 'required'
        ]);

        // dd($request->reg_no);

        if (Auth::guard('student')->attempt(['reg_no' => $request->reg_no, 'password' => $request->password])) {

          if (auth()->user()->isTeacher) {
                return redirect()->route('dashboard');
          }else{
                return redirect()->route('dashboard/student');
          }
        }else{
          return back()->withInput($request->only('reg_no', 'remember'));
        }
    }
}
