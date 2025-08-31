<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use App\Models\Grade;
use App\Models\Profile;
use App\Services\SaveCode;
use Illuminate\Http\Request;
use App\Scopes\HasActiveScope;
use App\Mail\SendTeacherDetails;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Traits\NotifiableParentsTrait;
use App\Http\Resources\v1\UserResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\v1\StaffResource;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        try {
            $type = $request->input('type');
            $search = $request->input('search');
            $perPage = $request->input('per_page', 20);
            $page = $request->input('page', 1);

            $query = User::whereNotIn('type', [User::SUPERADMIN, User::STUDENT]);

            if ($type !== null) {
                $query->where('type', $type);
            }

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('reg_no', 'like', "%{$search}%")
                      ->orWhere('phone_number', 'like', "%{$search}%");
                });
            }

            $users = $query->paginate($perPage, ['*'], 'page', $page);
            $staffs = StaffResource::collection($users);

            return response()->json([
                'status' => true,
                'staffs' => $staffs,
                'pagination' => [
                    'total' => $users->total(),
                    'per_page' => $users->perPage(),
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'from' => $users->firstItem(),
                    'to' => $users->lastItem(),
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'              => ['required'],
            'phone_number'              => ['required'],
            'type'              => ['required'],
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'success' => false,
                'message'  => $validator->errors()->all(),
            ], 400);
        }else{
            try {
                DB::transaction(function () use ($request) {
                        $user = new User([
                            'title' => $request->input('title'),
                            'name' => $request->name,
                            'email' => $request->email,
                            'phone_number' => $request->phone,
                            'password' => Hash::make($request->password),
                            'type' => $request->type
                        ]);
                        
                        $initial = 'TCH/';
                
                        if($request->input('type') === 2){
                            $initial = 'ADM/';
                        }elseif($request->input('type') === 3){
                            $initial = 'TCH/';
                        }elseif($request->input('type') === 5){
                            $initial = 'BUR/';
                        }elseif($request->input('type') === 6){
                            $initial = 'WOR/';
                        }
                
                        $code = SaveCode::Generator($initial, 3, 'reg_no', $user);
                        $user->reg_no = $code;
                
                        $message = "<p>You are welcome to ".application('name')." portal. Please visit ".application('website')." to login with your credentials. Id: ".$code." and your password: password1234</p>";
                        $subject = 'Welcome to '.application('name'). ' Portal';
                
                        if($request->type === '3'){
                            Mail::to($request->email)->send(new SendTeacherDetails($message, $subject));
                        }
                
                    if ($request->hasFile('image')) {
                        $uploadedFile = $request->file('image');
                        $fileName = $uploadedFile->getClientOriginalName();
                        $filePath = 'users/' . $fileName;
                        
                        if ($uploadedFile->storeAs('public', $filePath)) {
                            $user->profile_photo_path = $filePath;
                        } else {
                            return response()->json(['status' => false, 'message' => 'Failed to upload the file'], 400);
                        }
                    }
                    
                    $user->save();
                });
                return response()->json(['status' => true, 'message' => 'Staff created successfully'], 200);
            } catch (\Throwable $th) {
                return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
            }
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['sometimes', 'string'],
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'phone_number' => ['sometimes', 'string'],
            'type' => ['sometimes', 'integer'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all(),
            ], 400);
        }

        try {
            DB::transaction(function () use ($request, $id) {
                $user = User::findOrFail($id);
                $user->update($request->only(['title', 'name', 'email', 'phone_number', 'type']));

                if ($request->hasFile('image')) {
                    $uploadedFile = $request->file('image');
                    $fileName = $uploadedFile->getClientOriginalName();
                    $filePath = 'users/' . $fileName;

                    if ($uploadedFile->storeAs('public', $filePath)) {
                        $user->profile_photo_path = $filePath;
                    } else {
                        return response()->json(['status' => false, 'message' => 'Failed to upload the file'], 400);
                    }
                }

                $user->save();
            });
            return response()->json(['status' => true, 'message' => 'Staff updated successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all(),
            ], 400);
        }

        try {
            DB::transaction(function () use ($request, $id) {
                $user = User::findOrFail($id);
                $user->password = Hash::make($request->password);
                $user->save();
            });
            return response()->json(['status' => true, 'message' => 'Password updated successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function assignClass(Request $request)
    {
        try {
            $data = $request->validate([
                'teacher_id' => ['required', 'exists:users,id'],
                'grades'     => ['array'],
                'grades.*'   => ['integer', 'exists:grades,id'],
            ]);

            $teacher  = User::findOrFail($data['teacher_id']);
            $gradeIds = $data['grades'] ?? [];

            $teacher->gradeClassTeacher()->sync($gradeIds);

            return response()->json([
                'status'  => true,
                'message' => 'Classes synced successfully!',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function assignSubject(Request $request)
    {
        try {
            $data = $request->validate([
                'teacher_id' => ['required', 'exists:users,id'],
                'subjects'     => ['array'],
                'subjects.*'   => ['integer', 'exists:subjects,id'],
            ]);

            $teacher  = User::findOrFail($data['teacher_id']);
            $subjectIds = $data['subjects'] ?? [];

            $teacher->assignedSubjects()->sync($subjectIds);

            return response()->json([
                'status'  => true,
                'message' => 'Subjects synced successfully!',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
    
    public function deleteGrade($id, $staff)
    {
        try {
            $grade = Grade::find($id);
            $teacher = User::find($staff);
            $teacher->gradeClassTeacher()->detach($grade->id());

            return response()->json(['status' => true, 'message' => 'Grade for teacher deleted successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function single($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['status' => true, 'staff' => new StaffResource($user)], 200);
    }

    public function activate(Request $request)
    {
       try{

            DB::transaction(function () use ($request) {
                $staffId = $request->staff_id;
                $status = $request->status;
                $user = User::findOrFail($staffId);
                $user->update(['isAvailable' => $status === true ? 1 : 0]);
            });

            return response()->json(['status' => true, 'message' => 'Staff status updated successfully!'], 200);

       }catch(\Exception $th){
            DB::rollback();
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
       }
    }

    public function delete($id)
    {
        try {
            $teacher = User::findOrFail($id);

            // Unlink profile photo if exists
            if ($teacher->profile_photo_path && Storage::disk('public')->exists($teacher->profile_photo_path)) {
                Storage::disk('public')->delete($teacher->profile_photo_path);
            }

            $teacher->delete();
            return response()->json(['status' => true, 'message' => 'Staff deleted successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
        }
    }
}
