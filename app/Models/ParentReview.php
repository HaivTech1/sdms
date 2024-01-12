<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentReview extends Model
{
    use HasFactory;

     const TABLE = 'parent_reviews';

    protected $table = self::TABLE;

    protected $fillable = [
        'name', 
        'decription',
        'image',
        'status'
    ];

    protected $casts = [
        'status'  => 'boolean', 
    ];

    public function id(): string
    {
        return $this->id;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function discription(): ?string
    {
        return $this->discription;
    }

    public function image(): ?string
    {
        return $this->image;
    }
}
