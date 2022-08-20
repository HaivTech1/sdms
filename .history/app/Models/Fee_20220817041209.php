<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Fee extends Model
{
    use HasFactory, HasAuthor;
    
    const TABLE = 'fees';

    protected $table = self::TABLE;

    protected $fillable = [
        'title', 
        'price', 
        'status',
        'period_id',
        'term_id',
        'author_id'
    ];

    protected $casts = [
        'status'  => 'boolean',
    ];

    public function id(): string
    {
        return (string) (string) $this->id;
    }

    public function title(): string
    {
        return (string) $this->title;
    }

    public function price(): int
    {
        return (int) $this->price;
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function grades(): BelongsToMany
    {
        return $this->belongsToMany(Grade::class, 'fee_grade');
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