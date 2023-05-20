<?php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AssignedGradesScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $resultTemplate = get_settings('result_template');

        if (!auth()->user()->isAdmin() && !auth()->user()->isSuperAdmin()&& !auth()->user()->isStudent() && $resultTemplate == 0) {
            $userId = auth()->user()->id();
            
            $builder->whereHas('gradeClassTeacher', function (Builder $query) use ($userId) {
                $query->where('user_id', $userId);
            });
        }
    }
}
