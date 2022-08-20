<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fee extends Model
{
    use HasFactory, HasAuthor;
    
    const TABLE = 'fees';

    protected $table = self::TABLE;

    protected $fillable = [
        'title', 
        'price', 
        'status',
        'author_id'
    ];

    protected $casts = [
        'status'  => 'boolean',
    ]

    public function id(): string
    {
        return (string) $this->id;
    }

    public function title(): string
    {
        return (string) $this->title;
    }

    public function price(): int
    {
        return (int) $this->price;
    }
}