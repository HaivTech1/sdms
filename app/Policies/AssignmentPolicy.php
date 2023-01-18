<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Student;
use App\Models\Assignment;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssignmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user()->isTeacher() ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Student  $student
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Student $student, Assignment $assignment)
    {
        return $user()->isStudent() && $student->grade->id == $assignment->grade->id ? true : false;;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user()->isTeacher();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Student  $student
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Student $student, Assignment $assignment)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Student  $student
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Student $student, Assignment $assignment)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Student  $student
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Student $student, Assignment $assignment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Student  $student
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Student $student, Assignment $assignment)
    {
        //
    }
}
