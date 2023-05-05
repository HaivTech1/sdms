<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Timetable;
use Illuminate\Http\Request;
use App\Services\CalendarService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTimetableRequest;
use App\Http\Requests\UpdateTimetableRequest;

class TimetableController extends Controller
{
 
    public function index(CalendarService $calendarService)
    {
        $weekDays = Timetable::WEEK_DAYS;
        $calendarData = $calendarService->generateCalendarData($weekDays);
        $grades = Grade::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
        $subjects = Subject::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');
        $teachers = User::whereType(3)->get();
        return view('admin.timetable.index',[
            'weekDays' => $weekDays,
            'calendarData' => $calendarData,
            'grades' => $grades,
            'subjects' => $subjects,
            'teachers' => $teachers
        ]);
    }

    public function store(StoreTimetableRequest $request)
    {
        // dd($request);
        
        try {
            DB::transaction(function () use ($request) {
                $lesson = new Timetable([
                    'weekday' => $request->weekday,
                    'end_time' => $request->end_time,
                    'grade_id' => $request->grade_id,
                    'teacher_id' => $request->teacher_id,
                    'subject_id' => $request->subject_id,
                    'start_time' => $request->start_time,
                ]);
                $lesson->save();
            });
            return response()->json(['status' => true, 'message' => 'Created successfully'], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
        }
    }

    public function delete(Request $request, $id)
    {
        Timetable::where('id', $id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Lesson deleted successfully!'
        ], 200);
    }

    public function calender()
    {
        return view('admin.staff.calendar');
    }

    public function generatePDF()
    {
        $weeks = Week::where([
            'term_id' => term('id'),
            'period_id' => period('id'),
        ])->get();
        $html = view('pdf')->with(compact('weeks'))->render();

        // Return the generated HTML to the client
        return response()->json(['html' => $html]);
    }

    public function assign(Request $request)
    {
        $teacher = User::findOrFail($request->teacher_id);
        $week = Week::findOrFail($request->week_id);

        if ($week->teachers()->where('user_id', $teacher->id())->exists()) {
            return response()->json(['status' => false, 'message' => 'Teacher is currently assigned to this week!'], 500);
        }else{
            $week->teachers()->attach($teacher);
            return response()->json(['status' => true, 'message' => 'Teacher has assigned successfully!'], 200);
        }

    }
}
