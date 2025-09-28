<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AIResultComment extends Model
{
    use HasFactory, HasAuthor;

    protected $table = 'ai_result_comments';

    protected $fillable = [
        'student_uuid',
        'period_id',
        'term_id',
        'result_type',
        'author_id',
        'comment',
        'generated_at',
        'status',
        'notes'
    ];

    protected $casts = [
        'generated_at' => 'datetime',
    ];
}
