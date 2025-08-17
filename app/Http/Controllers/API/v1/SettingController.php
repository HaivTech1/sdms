<?php

namespace App\Http\Controllers\API\v1;

use App\Models\{
    Term,
    User,
    Grade,
    Period,
    Subject,
    Application,
    House,
    Permission,
    Role
};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\TermResource;
use App\Http\Resources\v1\GradeResource;
use App\Http\Resources\v1\SessionResource;
use App\Http\Resources\v1\SettingResource;
use App\Http\Resources\v1\SubjectResource;

class SettingController extends Controller
{
    public function index()
    {
        $application = new SettingResource(Application::first());

        try {
            return response()->json(['status' => true, 'settings' => $application], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
        }
    }

    public function grade()
    {
        $data = Grade::all();
        $grades = GradeResource::collection($data);
        return response()->json(['status' => 200, 'grades' => $grades], 200);
    }

    public function session()
    {
        $data = Period::all();
        $sessions = SessionResource::collection($data);
        return response()->json(['status' => 200, 'sessions' => $sessions], 200);
    }

    public function term()
    {
        $data = Term::all();
        $terms = TermResource::collection($data);
        return response()->json(['status' => 200, 'terms' => $terms], 200);
    }

    public function subject()
    {
        $data = Subject::all();
        $subjects = SubjectResource::collection($data);
        return response()->json(['status' => 200, 'subjects' => $subjects], 200);
    }

    public function houses()
    {
        $data = House::where('status', true)->get();
        $houses = [];
        foreach ($data as $value) {
            $houses[] = [
                'id' => $value->id,
                'title' => $value->title,
            ];
        }
        return response()->json(['status' => 200, 'houses' => $houses], 200);
    }

    public function midtermFormat()
    {
        try {
            $midterm = get_settings('midterm_format');
            return response()->json(['midterm' => $midterm], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function examFormat()
    {
        try {
            $exam = get_settings('exam_format');
            return response()->json(['exam' => $exam], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getSiteRoles()
    {
        try {

            $roles = Role::all();

            return response()->json([
                'status' => true,
                'roles' => $roles,
                'count' => count($roles)
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(ApiResponse(500, "There was an error fetching the roles."), 500);
        }
    }

    public function getSitePermissions()
    {
        try {
            $permissions = Permission::all();
            return response()->json([
                'status' => true,
                'permissions' => $permissions,
                'count' => count($permissions)
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(ApiResponse(500, "There was an error fetching the permissions."), 500);
        }
    }

    public function getRolePermissions($id)
    {
        try {

            $user = User::where('id', $id)->first();
            $permissions = $user->roles[0]->permissions;

            return response()->json([
                'status' => true,
                'role_permissions' => $permissions,
                'count' => count($permissions)
            ], 200);

        } catch (\Throwable $th) {
            info($th->getMessage());
            return response()->json(ApiResponse(500, "There was an error fetching the role permissions."), 500);
        }
    }
}
