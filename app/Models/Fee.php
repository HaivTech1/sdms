<?php

namespace App\Models;

use App\Traits\HasAuthor;
use App\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Fee extends Model
{
    use HasFactory, HasAuthor;
    
    const TABLE = 'fees';

    protected $table = self::TABLE;

    protected $fillable = [
        'grade_id',
        'term_id',
        'status',
        'type',
        'author_id'
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
        return  (string) $this->id;
    }

    public function type(): ?string
    {
        return (string) $this->type;
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function getTypeFeeAttribute()
    {

        $state = [
            'n' => 'Normal',
            's' => 'Staff Ward',
        ];

        return $state[$this->type];
    }

    public function scopeLoadLatest(Builder $query, $count = 4)
    {
        return $query->paginate($count);
    }

    public function details(): HasMany
    {
        return $this->hasMany(FeeDetail::class);
    }
}