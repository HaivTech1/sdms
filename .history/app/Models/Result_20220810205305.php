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
        'other_name',
        'gender',
        'dob',
        'nationality',
        'state_of_origin',
        'local_government',
        'address',
        'prev_school',
        'prev_class',
        'image',
        'medical_history',
        'allergics',
        'image',
        'grade_id',
        'status',
    ];

    protected $casts = [
        'dob' => 'datetime',
        'status' => 'boolean',
    ];
}