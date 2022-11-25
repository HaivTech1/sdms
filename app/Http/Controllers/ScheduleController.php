<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        return view('admin.schedule.index', [
            'schedules' => Schedule::all()
        ]);
    }
   
    public function store(StoreScheduleRequest $request)
    {
        $request->validated();

        $schedule = new schedule;
        $schedule->slug = $request->slug;
        $schedule->time_in = $request->time_in;
        $schedule->time_out = $request->time_out;
        $schedule->save();

        $notification = array (
            'messege' => 'Schedule has been created successfully!',
            'alert-type' => 'success',
            'button' => 'Okay!',
            'title' => 'Success'
        );

        return redirect()->back()->with($notification);
    }

    
    public function show(Schedule $schedule)
    {
        //
    }

   
    public function edit(Schedule $schedule)
    {
        //
    }

  
    public function update(StoreScheduleRequest $request, Schedule $schedule)
    {
        $request['time_in'] = str_split($request->time_in, 5)[0];
        $request['time_out'] = str_split($request->time_out, 5)[0];

        $request->validated();

        $schedule->slug = $request->slug;
        $schedule->time_in = $request->time_in;
        $schedule->time_out = $request->time_out;
        $schedule->save();

        $notification = array (
            'messege' => 'Schedule has been Updated successfully!',
            'alert-type' => 'success',
            'button' => 'Okay!',
            'title' => 'Success'
        );
        return redirect()->back()->with($notification);
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        $notification = array (
            'messege' => 'Schedule has been deleted successfully!',
            'alert-type' => 'success',
            'button' => 'Okay!',
            'title' => 'Success'
        );
        return redirect()->back()->with($notification);
    }
}
