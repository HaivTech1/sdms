<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Jobs\CreateUser;
use App\Services\SaveCode;
use Illuminate\Http\Request;
use App\Mail\SendTeacherDetails;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\v1\UserResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


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
       try {
          DB::transaction(function () use ($request) {
                $user = new User([
                    'title' => $request->title,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'password' => Hash::make($request->password),
                    'type' => $request->type
                ]);
        
                if($request->type == 2){
                    $initial = 'ADM/';
                }elseif($request->type == 3){
                    $initial = 'TCH/';
                }elseif($request->type == 5){
                    $initial = 'BUR/';
                }elseif($request->type == 6){
                    $initial = 'WOR/';
                }elseif($request->type == 8){
                    $initial = 'DRV/';
                }
        
                $code = SaveCode::Generator($initial, 5, 'reg_no', $user);
                $user->reg_no = $code;
        
                $message = "<p>You are welcome to ".application('name')." portal. Please visit ".application('website')." to login with your credentials. Id: ".$code." and your password: $request->password</p>";
                $subject = 'Welcome to '.application('name'). ' Portal';
        
                if($request->type === '3'){
                    Mail::to($request->email)->send(new SendTeacherDetails($message, $subject));
                }
        
                if($request->image){
                    $fileName = $request->image->getClientOriginalName();
                    $filePath = 'users/' . $fileName;
                    $isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($request->image));
            
                    if ($isFileUploaded) {
                        $user->profile_photo_path = $filePath;
                    }
                }
                $user->save();
          });
          return response()->json(['status' => true, 'message' => 'User created successfully'], 200);
       } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
       }
    }
    // profile-photos/SHjzZUK8XewhvwRkID1muK9ajLT5DUmTTcBytwf0.jpg
    public function me()
    {
        return new UserResource(auth()->user());
    }

    public function assignedGrade()
    {
        $user = auth()->user();
        $grades = $user->AssignedGrades();

        return response()->json($grades);
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

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            DB::transaction(function () use ($request, $user) {
                $user->update([
                    'title' => $request->filled('title') ? $request->title : $user->title,
                    'name' => $request->filled('name') ? $request->name : $user->name,
                    'email' => $request->filled('email') ? $request->email : $user->email,
                    'phone_number' => $request->filled('phone') ? $request->phone : $user->phone_number,
                    'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
                ]);
            });
            return response()->json([
                'status' => true, 
                'message' => 'Profile updated successfully!',
                'user' => $user,
            ], 200);
        } catch (\Throwable $th) {
                DB::rollback();
                return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }
    
    public function updateImage(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            if($request->image){
                $fileName = $request->image->getClientOriginalName();
                $filePath = 'users/' . $fileName;
                $isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($request->image));
        
                if ($isFileUploaded) {
                    $user->update([
                        'profile_photo_path' => $filePath,
                    ]);
                }
            }

            return response()->json([
                'status' => true, 
                'message' => 'Profile image uploaded successfully!',
                'user' => $user,
            ], 200);
        } catch (\Throwable $th) {
                DB::rollback();
                return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $user = User::findOrFail($request->user_id);
        $password = $request->password;

        $user->update([
            'password' => bcrypt($password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully'
        ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function roles($id)
    {
        $user = User::findOrFail($id);
        $roles = $user->roles;

        return response()->json(['status' => true, 'data' => $roles]);
    }

    public function assignRole (Request $request)
    {
        try {
            $user = User::findOrFail($request->user_id);
            $user->roles()->detach();
            $user->roles()->attach($request->roles);
            return response()->json(['status' => true, 'message' => 'Roles synced successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
        

    }

    public function deleteAssignedRole(User $user, Role $role)
    {
       try {
         $user->roles()->detach($role);
         return response()->json([
            'status' => true,
            'message' => 'Role removed successfully!'
         ], 200);
       } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
        ], 500);
       }
    }
}