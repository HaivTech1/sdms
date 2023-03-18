<?php

namespace App\Models;

use App\Cast\TitleCast;
use App\Traits\HasAuthor;
use App\Scopes\HasActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;
    use HasAuthor;

    const TABLE = 'news';

    protected $table = self::TABLE;

    protected $fillable = [
        'title', 
        'description', 
        'period_id',
        'term_id',
        'author_id',
        'status'
    ];

    protected $casts = [
        'status'  => 'boolean', 
        'title' => TitleCast::class,
    ];

    protected static function booted()
    {
        static::addGlobalScope(new HasActiveScope);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function status(): bool
    {
        return $this->status;
    }

    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }

    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id');
    }
}
