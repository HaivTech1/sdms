<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    const SUPERADMIN = 'superadmin';
    const ADMIN = 'admin';
    const TEACHER = 'teacher';
    const STUDENT = 'student';
    const BURSAL = 'bursal';
    const CLASSTEACHER = 'class_teacher';
    const BAN = 'ban';
    const DELETE = 'delete';


    public function student(User $user): bool
    {
        return $user->isStudent();
    }

    public function teacher(User $user): bool
    {
        return $user->isTeacher() || $user->isSuperAdmin();
    }

    public function bursal(User $user): bool
    {
        return $user->isBursal() || $user->isSuperAdmin() ||  $user->isAdmin();
    }

    public function admin(User $user): bool
    {
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    public function superadmin(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function ban(User $user, User $subject): bool
    {
        return ($user->isAdmin() || $user->isSuperAdmin());
    }

    public function delete(User $user, User $subject)
    {
        return ($user->isAdmin() || $user->matches($subject)) && !$subject->isAdmin() || $user->isSuperAdmin();
    }

    public function class_teacher(User $user)
    {
         return ($user->gradeClassTeacher()->exists());
    }
}