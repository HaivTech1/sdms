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

        foreach ($timeRange as $time)
        {
            $timeText = $time['start'] . ' - ' . $time['end'];
            $calendarData[$timeText] = [];

            foreach ($weekDays as $index => $day)
            {
                $lessons = Timetable::with('grade', 'teacher', 'subject')
                    ->calendarByRoleOrGradeId()
                    ->where('weekday', $index)
                    ->where('start_time', '<=', $time['start'])
                    ->where('end_time', '>=', $time['end'])
                    ->get();

                if ($lessons->count()) {
                    foreach ($lessons as $lesson) {
                        array_push($calendarData[$timeText], [
                            'id' => $lesson->id(),
                            'week'          => $lesson->weekday,
                            'class_name'   => $lesson->grade->title(),
                            'teacher_name' => $lesson->teacher->name(),
                            'subject_name' => $lesson->subject->title(),
                            'rowspan'      => 1
                        ]);
                    }
                }
                else if (!$lessons->count()) {
                    array_push($calendarData[$timeText], 0);
                }
            }
        }

        return $calendarData;
    }

}
