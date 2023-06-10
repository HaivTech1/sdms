<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Graduate extends Model
{
    use HasFactory, HasAuthor;

    const TABLE = 'graduates';

    protected $table = self::TABLE;

    protected $fillable = [
        'author_id',
        'student_id', 
        'period_id',
        'term_id',
        'grade_id'
    ];

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }
}
