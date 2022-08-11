<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Result extends Model
{
    use HasFactory;
    use HasUuid;
    
    const TABLE = 'results';

    public $table = self::TABLE;

    protected $fillable = [
        'uuid',
        'session_id',
        'term_id',
        'grade_id',
        'subject_id',
        'student_id',
        'ca1',
        'ca2',
        'ca3',
        'exam'
    ];

    protected $casts = [
        'dob' => 'datetime',
        'status' => 'boolean',
    ];
}