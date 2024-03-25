<?php

namespace App\Models;

use App\Cast\TitleCast;
use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    use HasAuthor;

    const TABLE = 'events';

    protected $table = self::TABLE;

    protected $fillable = [
        'title', 
        'start', 
        'end',
        'week_id', 
        'category',
        'period_id',
        'term_id',
        'author_id'
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'title' => TitleCast::class,
    ];

    public function id(): string
    {
        return  (string) $this->id;
    }

    public function title(): string
    {
        return (string) $this->title;
    }

    public function category(): string
    {
        return $this->category;
    }

    public function start(): string
    {
        return $this->start->format('d-m-Y');
    }

    public function end(): string
    {
        return $this->end->format('d-m-Y');
    }

    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }

    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id');
    }

    public function week()
    {
        return $this->belongsTo(Week::class, 'week_id');
    }
    
}
