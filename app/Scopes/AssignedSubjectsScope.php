<?php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AssignedSubjectsScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $resultTemplate = get_settings('result_template');

        if (auth()->check() && !auth()->user()->isAdmin() && !auth()->user()->isSuperAdmin() && !auth()->user()->isStudent() && !auth()->user()->gradeClassTeacher()->exists() && $resultTemplate == 1) {
            $userId = auth()->user()->id();
            
            $builder->whereHas('teachers', function (Builder $query) use ($userId) {
                $query->where('user_id', $userId);
            });
        }
    }
}
