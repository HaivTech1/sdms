<?php

namespace App\Models;

use App\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubGrade extends Model
{
    use HasFactory;

    const TABLE = 'sub_grades';

    protected $table = self::TABLE;

    protected $fillable = [
        'title', 
        'grade_id',
        'status'
    ];

    protected $casts = [
        'status'  => 'boolean', 
    ];

    protected static function booted()
    {
        static::addGlobalScope(new HasActiveScope);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function status(): bool
    {
        return $this->status;
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class, 'grade_id');
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
