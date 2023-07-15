<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    const TABLE = 'vehicles';

    protected $table = self::TABLE;

    protected $fillable = [
        'name',
        'plate_no',
        'seats',
        'type',  
        'status'
    ];

    protected $casts = [
        'status'  => 'boolean', 
    ];

    public function id(): int
    {
        return (int) $this->id;
    }

    public function name(): string
    {
        return (string) $this->name;
    }

    public function plateNo(): string
    {
        return (string) $this->plate_no;
    }

    public function seat(): int
    {
        return (int) $this->seats;
    }

    public function type(): string
    {
        return (string) $this->type;
    }

    public function getVehicleIconeAttribute()
    {

        $icon = [
            'car' => 'bx bx-car',
            'bus' => 'bx bx-bus',
        ];

        return $icon[$this->type];
    }
}
