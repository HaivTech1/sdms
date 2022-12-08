<?php

namespace App\Models;

use App\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class House extends Model
{
    use HasFactory;

    const TABLE = 'houses';

    protected $table = self::TABLE;

    protected $fillable = [
        'title', 
        'status'
    ];

    protected $with = [
     'students'
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

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function houseMasters(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'house_user');
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
