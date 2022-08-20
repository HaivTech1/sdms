<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    const TABLE = 'payments';

    protected $table = self::TABLE;

    protected $fillable = [
        'period_id',
        'term_id',
        'student_uuid',
        'amount',
        'balance',
        'type',
        'status'
    ];

    protected $casts = [
        'status'  => 'boolean', 
    ];

    public function id(): string
    {
        return $this->id;
    }

    public function status(): bool
    {
        return $this->status;
    }
}