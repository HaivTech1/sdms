<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hairstyle extends Model
{
    use HasFactory;

    const TABLE = 'hairstyles';

    public $table = self::TABLE;

    protected $fillable = [
        'title',
        'description',
        'back_view',
        'front_view',
        'side_view',
    ];

    public function id(): string
    {
        return (string) $this->id;
    }

    public function title(): string
    {
        return (string) $this->title;
    }

    public function description(): string
    {
        return (string) $this->description;
    }
    
}
