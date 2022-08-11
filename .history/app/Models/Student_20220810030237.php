<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;
    use HasUuid;

    const TABLE = 'posts';

    public $table = self::TABLE;

    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'description',
        'is_commentable',
        'image',
        'published_at',
        'type',
        'author_id',
        'photo_credit_text',
        'photo_credit_link',
        'post_category_id',
        'isAvailable',
        'isVerified',
    ];
}
