<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    const TABLE = 'banners';
    protected $table = self::TABLE;

    protected $fillable = [
        'title',
        'sub_title',
        'description',
        'button_text',
        'wide_banner',
        'feature_one_title',
        'feature_two_title',
        'feature_three_title',
        'feature_one',
        'feature_two',
        'feature_three',
    ];
}
