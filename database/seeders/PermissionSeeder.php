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
                'id'    => '17',
                'title' => 'audit_log_show',
            ],
            [
                'id'    => '18',
                'title' => 'audit_log_access',
            ],
            [
                'id'    => '19',
                'title' => 'status_create',
            ],
            [
                'id'    => '20',
                'title' => 'status_edit',
            ],
            [
                'id'    => '21',
                'title' => 'status_show',
            ],
            [
                'id'    => '22',
                'title' => 'status_delete',
            ],
            [
                'id'    => '23',
                'title' => 'status_access',
            ],
            [
                'id'    => '24',
                'title' => 'loan_application_create',
            ],
            [
                'id'    => '25',
                'title' => 'loan_application_edit',
            ],
            [
                'id'    => '26',
                'title' => 'loan_application_show',
            ],
            [
                'id'    => '27',
                'title' => 'loan_application_delete',
            ],
            [
                'id'    => '28',
                'title' => 'loan_application_access',
            ],
            [
                'id'    => '29',
                'title' => 'comment_create',
            ],
            [
                'id'    => '30',
                'title' => 'comment_edit',
            ],
            [
                'id'    => '31',
                'title' => 'comment_show',
            ],
            [
                'id'    => '32',
                'title' => 'comment_delete',
            ],
            [
                'id'    => '33',
                'title' => 'comment_access',
            ],
            [
                'id'    => '34',
                'title' => 'profile_password_edit',
            ],
            [
                'id'    => '35',
                'title' => 'add_referee',
            ],
            [
                'id'    => '36',
                'title' => 'add_institution',
            ],
            [
                'id'    => '37',
                'title' => 'payment_access',
            ],
            [
                'id'    => '38',
                'title' => 'files_access',
            ],
            [
                'id'    => '39',
                'title' => 'testimomy_access',
            ],
            [
                'id'    => '40',
                'title' => 'ask_access',
            ],
            [
                'id'    => '41',
                'title' => 'newsletter_access',
            ],
            [
                'id'    => '42',
                'title' => 'faq_access',
            ],
            [
                'id'    => '43',
                'title' => 'blog_access',
            ],
            [
                'id'    => '44',
                'title' => 'blog_create',
            ],
            [
                'id'    => '45',
                'title' => 'blog_edit',
            ],
            [
                'id'    => '46',
                'title' => 'blog_show',
            ],
            [
                'id'    => '47',
                'title' => 'delete',
            ],
            [
                'id'    => '48',
                'title' => 'faq_create',
            ],
            [
                'id'    => '49',
                'title' => 'faq_edit',
            ],
            [
                'id'    => '50',
                'title' => 'faq_show',
            ],
            [
                'id'    => '51',
                'title' => 'newsletter_delete',
            ],
            [
                'id'    => '52',
                'title' => 'message',
            ],
            [
                'id'    => '53',
                'title' => 'file_show',
            ],
            [
                'id'    => '54',
                'title' => 'files_edit',
            ],
            [
                'id'    => '55',
                'title' => 'files_delete',
            ],
            [
                'id'    => '56',
                'title' => 'faq_delete',
            ],
            [
                'id'    => '57',
                'title' => 'payment_access',
            ],
        ];

        Permission::insert($permissions);
    }
}