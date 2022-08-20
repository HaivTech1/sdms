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
        'title', 
        'status'
    ];

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

    public function status(): bool
    {
        return $this->status;
    }
}