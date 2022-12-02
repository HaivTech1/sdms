<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choose extends Model
{
    use HasFactory;

    const TABLE = 'chooses';
    protected $table = self::TABLE;

    protected $fillable = [
        'topic',
        'intention',
        'logo',
    ];
}
