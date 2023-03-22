<?php

namespace App\Models;

use App\Models\Hairstyle;
use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function hairstyle()
    {
        return $this->belongsTo(Hairstyle::class);
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
            $week->hairstyle_id = $week->getRandomHairstyleId();
            $week->save();

            $weeks[] = $week;

            $startDate->addWeek();
        }

        return $weeks;
    }

    public function getRandomHairstyleId()
    {
        $hairstyles = Hairstyle::all();
        $randomHairstyle = $hairstyles->random();
        return $randomHairstyle->id;
    }
}
