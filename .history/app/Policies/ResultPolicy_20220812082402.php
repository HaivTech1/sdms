<?php

namespace App\Policies;

use App\Models\Result;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResultPolicy
{
    const UPDATE = 'update';

    public function update(Type $var = null)
    {
        # code...
    }
}