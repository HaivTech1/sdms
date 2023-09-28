<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'id'    => '1',
                'title' => 'user_management_access',
            ],
            [
                'id'    => '2',
                'title' => 'permission_create',
            ],
            [
                'id'    => '3',
                'title' => 'permission_edit',
            ],
            [
                'id'    => '4',
                'title' => 'permission_show',
            ],
            [
                'id'    => '5',
                'title' => 'permission_delete',
            ],
            [
                'id'    => '6',
                'title' => 'permission_access',
            ],
            [
                'id'    => '7',
                'title' => 'role_create',
            ],
            [
                'id'    => '8',
                'title' => 'role_edit',
            ],
            [
                'id'    => '9',
                'title' => 'role_show',
            ],
            [
                'id'    => '10',
                'title' => 'role_delete',
            ],
            [
                'id'    => '11',
                'title' => 'role_access',
            ],
            [
                'id'    => '12',
                'title' => 'user_create',
            ],
            [
                'id'    => '13',
                'title' => 'user_edit',
            ],
            [
                'id'    => '14',
                'title' => 'user_show',
            ],
            [
                'id'    => '15',
                'title' => 'user_delete',
            ],
            [
                'id'    => '16',
                'title' => 'user_access',
            ],
            [
                'id' => '17',
                'title' => 'payment_create'
            ],
            [
                'id' => '18',
                'title' => 'result_create'
            ],
            [
                'id' => '19',
                'title' => 'result_edit'
            ],
            [
                'id' => '20',
                'title' => 'result_show'
            ],
            [
                'id' => '21',
                'title' => 'result_access'
            ],
            [
                'id' => '22',
                'title' => 'setting_access'
            ],
            [
                'id' => '23',
                'title' => 'student_list_access'
            ],
            [
                'id' => '24',
                'title' => 'account_access'
            ],
            [
                'id' => '25',
                'title' => 'fee_create'
            ],
            [
                'id' => '26',
                'title' => 'payment_access'
            ],
            [
                'id' => '27',
                'title' => 'payslip_access'
            ],
            [
                'id' => '28',
                'title' => 'attendance_create'
            ],
            [
                'id' => '29',
                'title' => 'lesson_create'
            ],
            [
                'id' => '30',
                'title' => 'assignment_create'
            ],
            [
                'id' => '31',
                'title' => 'student_result_access'
            ],
            [
                'id' => '32',
                'title' => 'student_assignment_access'
            ],
            [
                'id' => '33',
                'title' => 'student_lesson_access'
            ],
            [
                'id' => '34',
                'title' => 'student_access'
            ],
            [
                'id' => '35',
                'title' => 'student_fee_access'
            ],
            [
                'id' => '36',
                'title' => 'student_result_access'
            ],
            [
                'id' => '37',
                'title' => 'student_assignment_access'
            ],
            [
                'id' => '38',
                'title' => 'student_lesson_access'
            ],
            [
                'id' => '39',
                'title' => 'student_market_access'
            ],
            [
                'id' => '40',
                'title' => 'timetable_access'
            ],
            [
                'id' => '41',
                'title' => 'calendar_access'
            ],
            [
                'id' => '42',
                'title' => 'schoolbus_access'
            ],
            [
                'id' => '43',
                'title' => 'broadsheet_access'
            ],
            [
                'id' => '44',
                'title' => 'statistic_access'
            ],
            [
                'id' => '45',
                'title' => 'website_access'
            ],
            [
                'id' => '46',
                'title' => 'staff_access'
            ],
            [
                'id' => '47',
                'title' => 'registration_access'
            ],
            [
                'id' => '48',
                'title' => 'promotion_access'
            ],
            [
                'id' => '49',
                'title' => 'certificate_access'
            ],
            [
                'id' => '50',
                'title' => 'messaging_access'
            ],
            [
                'id' => '51',
                'title' => 'transport_access'
            ],
            [
                'id' => '52',
                'title' => 'ecommerce_access'
            ],
            [
                'id' => '53',
                'title' => 'whatsapp_access'
            ],
            [
                'id' => '54',
                'title' => 'scratchcard_access'
            ],
            [
                'id' => '55',
                'title' => 'student_midterm_access'
            ],
            [
                'id' => '56',
                'title' => 'student_exam_access'
            ],
            [
                'id' => '57',
                'title' => 'principal_comment'
            ],
            [
                'id' => '58',
                'title' => 'psychomotor_create'
            ],
            [
                'id' => '59',
                'title' => 'affective_create'
            ],
            [
                'id' => '60',
                'title' => 'result_publish'
            ],
            [
                'id' => '61',
                'title' => 'download_result'
            ],
            [
                'id' => '62',
                'title' => 'result_download'
            ],
            [
                'id' => '63',
                'title' => 'position_access'
            ],
            [
                'id' => '64',
                'title' => 'result_comment'
            ],
        ];

        Permission::insert($permissions);
    }
}