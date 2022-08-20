<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;
    
    const TABLE = 'fees';

    protected $table = self::TABLE;

    protected $fillable = [
        'title', 
        'price', 
        'status'
    ];

    protected $casts = [
        'status'  => 'boolean',
    ]
}