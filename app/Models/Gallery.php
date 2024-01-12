<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    const TABLE = 'galleries';
    protected $table = self::TABLE;
    protected $fillable = [
        'title',
        'image',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function id(): int
    {
        return (int) $this->id;
    }

    public function title(): ?string
    {
        return (string) $this->title;
    }

    public function image(): string
    {
        return "storage/". $this->image ;
    }
}
