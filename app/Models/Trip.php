<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'vehicle_id',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
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

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
