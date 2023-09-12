<?php

namespace App\Models;

use App\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Trip extends Model
{
    use HasFactory;

    const TABLE = 'trips';
    protected $table = self::TABLE;
    protected $fillable = [
        'address',
        'longitude',
        'latitude',
        'distance',
        'no_of_students',
        'price',
        'split',
        'split_type',
        'status'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new HasActiveScope);
    }

    protected $casts = [
        'status' => 'boolean',
        'split' => 'boolean',
    ];

    public function id(): int
    {
        return (int) $this->id;
    }

    public function address(): string
    {
        return (string) $this->address;
    }

    public function longitude(): ?string
    {
        return (string) $this->longitude;
    }

    public function latitude(): ?string
    {
        return (string) $this->latitude;
    }

    public function duration(): ?string
    {
        return (string) $this->duration;
    }

    public function studentsCount(): ?int
    {
        return (int) $this->no_of_students;
    }

    public function price(): ?int
    {
        return (int) $this->price;
    }

    public function scopeLoad(Builder $query, $count = 5)
    {
        return $query->paginate($count);
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return $query->where(function($query) use ($term) {
            $query->where('address', 'like', $term);
        });
    }

    public function getStatusTypeAttribute()
    {

        $state = [
            true => 'Active',
            false => 'Disabled',
        ];

        return $state[$this->status];
    }

    public function getSplitStatusAttribute()
    {

        $state = [
            true => 'Active',
            false => 'Disabled',
        ];

        return $state[$this->split];
    }

    public function studentTrips(): HasMany
    {
        return $this->hasMany(StudentTrip::class, 'trip_id');
    }

}