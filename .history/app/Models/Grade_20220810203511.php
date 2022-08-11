<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Grade extends Model
{
    use HasFactory;

    const TABLE = 'grades';

    protected $table = self::TABLE;

    protected $fillable = [
        'title', 
        'status'
    ];

    protected $with = [
        'subjects'
    ]

    protected $casts = [
        'status'  => 'boolean', 
    ];

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function status(): boolean
    {
        return $this->status;
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
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