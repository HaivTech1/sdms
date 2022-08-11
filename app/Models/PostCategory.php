<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    const TABLE = 'post_categories';

    public $table = self::TABLE;

    protected $fillable = [
        'name',
        'image', 
        'slug', 
    ];

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function image(): string
    {
        return $this->image;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}