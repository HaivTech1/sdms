<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cognitive extends Model
{
    use HasFactory;

    const TABLE = 'cognitives';

    protected $table = self::TABLE;

    protected $fillable = [
        'attendance_duration', 
        'attendance_present', 
        'comment',
        'principal_comment',
        'promotion_comment',
        'position_in_class',
        'position_in_grade',
        'student_uuid', 
        'term_id',
        'period_id',
    ];

    protected $casts = [
    ];

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function duration(): string
    {
        return $this->attendance_duration;
    }

    public function present(): string
    {
        return $this->attendance_present;
    }

    public function comment(): ?string
    {
        return $this->comment;
    }

    public function pComment(): ?string
    {
        return $this->principal_comment;
    }

    public function promotionComment(): ?string
    {
        return $this->promotion_comment;
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return $query->where(function($query) use ($term) {
            $query->where('title', 'like', $term);
        });
    }

    public function scopeLoadLatest(Builder $query, $count = 4)
    {
        return $query->paginate($count);
    }
}