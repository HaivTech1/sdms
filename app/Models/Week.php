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
    protected $fillable = ['start_date', 'end_date', 'hairstyle_id', 'period_id', 'term_id', 'author_id'];

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

            $teachers = User::where('type', User::TEACHER)->get();
            $teachers = $teachers->shuffle();

            $userIds = $teachers->pluck('id')->toArray();
            $assignedUsers = [];
            for ($i = 0; $i < 2; $i++) {
                do {
                    $userId = array_pop($userIds);
                } while (in_array($userId, $assignedUsers) && !empty($userIds));
                if (!in_array($userId, $assignedUsers)) {
                    $week->teachers()->attach($userId);
                    $assignedUsers[] = $userId;
                }
            }

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

    public function teachers()
    {
        return $this->belongsToMany(User::class);
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
