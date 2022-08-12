<?php

namespace App\Policies;

use App\Models\Result;
use App\Models\User;

class ResultPolicy
{
    const UPDATE = 'update';

    public function update(User $user, Result $result)
    {
        return $this->isAuthoredBy($user) || $user->isSuperAdmin() || $user->isAdmin();
    }
}