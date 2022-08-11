<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    const SUPERADMIN = 'superadmin';
    const ADMIN = 'admin';
    const STAFF = 'staff';
    const STUDENT = 'student';
    const BAN = 'ban';
    const DELETE = 'delete';


    public function student(User $user): bool
    {
        return $user->isStudent() || $user->isAdmin() || $user->isSuperAdmin();
    }

    public function staff(User $user): bool
    {
        return $user->isStaff() || $user->isAdmin() || $user->isSuperAdmin();
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
}