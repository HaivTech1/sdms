<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    const TABLE = 'abouts';
    protected $table = self::TABLE;

    protected $fillable = [
        'title',
        'description_one',
        'description_two',
        'big_image',
        'small_image_one',
        'small_image_two',
    ];
}
