<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $all_permissions = Permission::all();
        $admin_permissions = $all_permissions->filter(function ($permission) {
            return $permission->title != 'payment_create' || !str_starts_with($permission->title, 'student');
        });
        Role::findOrFail(1)->permissions()->sync($admin_permissions);

        $secretary_permissions = $all_permissions->filter(function ($permission) {
            return $permission->title != 'payment_create' && !str_starts_with($permission->title, 'student');
        });
        Role::findOrFail(2)->permissions()->sync($secretary_permissions);

        $class_teacher_permissions = $all_permissions->filter(function ($permission) {
            return in_array($permission->title, [
                'result_access', 'broadsheet_access', 'result_edit', 'result_show', 'student_list_access'
            ]) && !str_starts_with($permission->title, 'student');
        });
        Role::findOrFail(3)->permissions()->sync($class_teacher_permissions);

        $subject_teacher_permissions = $all_permissions->filter(function ($permission) {
            return in_array($permission->title, [
                'result_access', 'result_create',
            ]) && !str_starts_with($permission->title, 'student');
        });
        Role::findOrFail(4)->permissions()->sync($subject_teacher_permissions);

        $student_permissions = $all_permissions->filter(function ($permission) {
            return str_starts_with($permission->title, 'student');
        });
        Role::findOrFail(5)->permissions()->sync($student_permissions);
    }
}