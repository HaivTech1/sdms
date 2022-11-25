<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Result;
use App\Models\Student;

class ResultPolicy
{
    const UPDATE = 'update';
    const PUBLISH = 'publish';
    
    public function update(User $user, Result $result): bool
    {
        return $result->isAuthoredBy($user) || $user->isSuperAdmin() || $user->isAdmin();
    }

    // public function publish(Result $result, Student $student): bool
    // {
    //     return;
    // }
}