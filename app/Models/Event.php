<?php

namespace App\Models;

use App\Cast\{
    TitleCast, 
    TimeCast
};
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
        'description',
        'start_date', 
        'end_date',
        'time',
        'category',
        'period_id',
        'term_id',
        'author_id'
    ];

    protected $casts = [
        'start_date' => 'datetime:Y-m-d H:i:s',
        'end_date' => 'datetime:Y-m-d H:i:s',
        'time' => TimeCast::class,
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

    public function description(): string
    {
        return (string) $this->description;
    }

    public function category(): string
    {
        return $this->category;
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
