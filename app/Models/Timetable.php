<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Timetable extends Model
{
    use HasFactory;

    const TABLE = 'timetables';
    protected $table = self::TABLE;

    const WEEK_DAYS = [
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
    ];

    protected $fillable = [
        'weekday',
        'end_time',
        'grade_id',
        'teacher_id',
        'subject_id',
        'start_time',
    ];

    public function id()
    {
        return $this->id;
    }

    public function getDifferenceAttribute()
    {
        return Carbon::parse($this->end_time)->diffInMinutes($this->start_time);
    }

    public function getStartTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('H:i:s', $value)->format(config('settings.lesson_time_format')) : null;
    }

    public function setStartTimeAttribute($value)
    {
        $this->attributes['start_time'] = $value ? Carbon::createFromFormat(config('settings.lesson_time_format'),
            $value)->format('H:i:s') : null;
    }

    public function getEndTimeAttribute($value)
    {
        return $value ? Carbon::createFromFormat('H:i:s', $value)->format(config('settings.lesson_time_format')) : null;
    }

    public function setEndTimeAttribute($value)
    {
        $this->attributes['end_time'] = $value ? Carbon::createFromFormat(config('settings.lesson_time_format'),
            $value)->format('H:i:s') : null;
    }

    function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public static function isTimeAvailable($weekday, $startTime, $endTime, $class, $teacher, $lesson)
    {
        $lessons = self::where('weekday', $weekday)
            ->when($lesson, function ($query) use ($lesson) {
                $query->where('id', '!=', $lesson);
            })
            ->where(function ($query) use ($class, $teacher) {
                $query->where('grade_id', $class)
                    ->orWhere('teacher_id', $teacher);
            })
            ->where([
                ['start_time', '<', $endTime],
                ['end_time', '>', $startTime],
            ])
            ->count();

        return !$lessons;
    }

    public function scopeCalendarByRoleOrGradeId($query)
    {
        return $query->when(!request()->input('grade_id'), function ($query) {
            $query->when(auth()->user()->isTeacher(), function ($query) {
                $query->where('teacher_id', auth()->user()->id());
            })
                ->when(auth()->user()->isStudent(), function ($query) {
                    $query->where('grade_id', auth()->user()->student->grade_id ?? '0');
                });
        })
        ->when(request()->input('grade_id'), function ($query) {
            $query->where('grade_id', request()->input('grade_id'));
        });
    }
}
