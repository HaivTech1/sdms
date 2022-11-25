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
        'title', 
        'rate', 
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

    public function title(): string
    {
        return $this->title;
    }

    public function rate(): int
    {
        return $this->rate;
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
