<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Week extends Model
{
    use HasFactory, HasAuthor;
    protected $fillable = ['start_date', 'end_date', 'period_id', 'term_id', 'author_id'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'date',
    ];

    public function id(): string
    {
        return  (string) $this->id;
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public static function generateWeeks($startDate, $endDate)
    {
        $weeks = [];

        while ($startDate->lessThanOrEqualTo($endDate)) {
            $week = new Week;
            $week->start_date = $startDate->copy()->startOfWeek();
            $week->end_date = $startDate->copy()->endOfWeek();
            $week->period_id = period('id');
            $week->term_id = term('id');
            // $week->author_id = auth()->id();
            $week->save();

            $weeks[] = $week;

            $startDate->addWeek();
        }

        return $weeks;
    }
}
