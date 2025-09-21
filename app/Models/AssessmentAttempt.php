<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentAttempt extends Model
{
    use HasFactory;

    protected $table = 'assessment_attempts';

    protected $fillable = [
        'attempt_id', 'user_id', 'subject_id', 'week_id', 'client', 'submitted_at', 'meta'
    ];

    protected $casts = [
        'meta' => 'array',
        'submitted_at' => 'datetime',
    ];

    public function answers()
    {
        return $this->hasMany(AttemptAnswer::class, 'attempt_id');
    }
}
