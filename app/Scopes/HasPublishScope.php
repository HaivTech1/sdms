<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class HasPublishScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if(auth()->user() && auth()->user()->isStudent()) {
            $builder->where('published', true);
        }
    }
}