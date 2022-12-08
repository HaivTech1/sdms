<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use App\Models\Timetable;
use App\Services\CalendarService;
use App\Http\Requests\StoreTimetableRequest;
use App\Http\Requests\UpdateTimetableRequest;

class TimetableController extends Controller
{
 
    public function index(CalendarService $calendarService)
    {
        $weekDays = Timetable::WEEK_DAYS;
        $calendarData = $calendarService->generateCalendarData($weekDays);
        $grades = Grade::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
        $teachers = User::whereType(3)->get();
        return view('admin.timetable.index',[
            'weekDays' => $weekDays,
            'calendarData' => $calendarData,
            'grades' => $grades,
            'teachers' => $teachers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTimetableRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTimetableRequest $request)
    {
        // dd($request);
        $lesson = new Timetable([
            'weekday' => $request->weekday,
            'end_time' => $request->end_time,
            'grade_id' => $request->grade_id,
            'teacher_id' => $request->teacher_id,
            'start_time' => $request->start_time,
        ]);

        if ($lesson->save()) {
            return response()->json(['status' => 'success', 'message' => 'Created successfully'], 200);
        }else{
        return response()->json(['status' => 'error', 'message' => 'There was an error'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Timetable  $timetable
     * @return \Illuminate\Http\Response
     */
    public function show(Timetable $timetable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Timetable  $timetable
     * @return \Illuminate\Http\Response
     */
    public function edit(Timetable $timetable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTimetableRequest  $request
     * @param  \App\Models\Timetable  $timetable
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTimetableRequest $request, Timetable $timetable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Timetable  $timetable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Timetable $timetable)
    {
        //
    }
}
