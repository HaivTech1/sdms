<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'superadmin']);
    }

    public function index()
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.role.index');
    }

     public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role->delete();

        return back();
    }

    public function permissions($id)
    {
        $role = Role::findOrFail($id);
        $permissions = $role->permissions;

        return response()->json(['status' => true, 'data' => $permissions]);
    }

    public function assignPermission (Request $request)
    {
        try {
            $role = Role::findOrFail($request->role_id);
            $role->permissions()->detach();
            $role->permissions()->attach($request->permissions);
            return response()->json(['status' => true, 'message' => 'Permissions synced successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
        

    }

    public function deleteAssignedPermission(Role $role, Permission $permission)
    {
       try {
         $role->permissions()->detach($permission);
         return response()->json([
            'status' => true,
            'message' => 'Permission removed successfully!'
         ], 200);
       } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
        ], 500);
       }
    }
}