<?php

namespace App\Services;

use App\Models\Schedule;
use App\Models\Timetable;
use App\Services\TimeService;


class CalendarService
{
    public function generateCalendarData($weekDays)
    {
        $schedule = Schedule::whereSlug('Student')->first();
        $calendarData = [];
        $timeRange = (new TimeService)->generateTimeRange($schedule->time_in->format('H:i'), $schedule->time_out->format('H:i'));
        $lessons   = Timetable::with('grade', 'teacher')
            ->calendarByRoleOrGradeId()
            ->get();

        foreach ($timeRange as $time)
        {
            $timeText = $time['start'] . ' - ' . $time['end'];
            $calendarData[$timeText] = [];

            foreach ($weekDays as $index => $day)
            {
                $lesson = $lessons->where('weekday', $index)->where('start_time', $time['start'])->first();

                if ($lesson)
                {
                    array_push($calendarData[$timeText], [
                        'class_name'   => $lesson->grade->title(),
                        'teacher_name' => $lesson->teacher->name(),
                        'rowspan'      => $lesson->difference/30 ?? ''
                    ]);
                }
                else if (!$lessons->where('weekday', $index)->where('start_time', '<', $time['start'])->where('end_time', '>=', $time['end'])->count())
                {
                    array_push($calendarData[$timeText], 1);
                }
                else
                {
                    array_push($calendarData[$timeText], 0);
                }
            }
        }

        return $calendarData;
    }
}
