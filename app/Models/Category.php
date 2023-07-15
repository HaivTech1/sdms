<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    const TABLE = 'categories';
    protected $table = self::TABLE;
    protected $fillable = [
        'title',
    ];

    public function id(): int
    {
        return (int) $this->id;
    }

    public function title(): string
    {
        return (string) $this->title;
    }
}
