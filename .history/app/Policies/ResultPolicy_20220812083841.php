<?php

namespace App\Policies;

use App\Models\Result;
use App\Models\User;

class ResultPolicy
{
    const UPDATE = 'update';
    const CREATE = 'create';

    public function create(User $user): bool
    {
        return $user->isStaff() || $user->isAdmin() || $this->isAuthoredBy($user) || ;
    }
    
    public function update(User $user, Result $result): bool
    {
        return $this->isAuthoredBy($user) || $user->isSuperAdmin() || $user->isAdmin();
    }
}