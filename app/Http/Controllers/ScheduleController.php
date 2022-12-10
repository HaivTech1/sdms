<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
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

    public function fetch()
    {
        $schedules = Schedule::all();
        return response()->json(['schedules' => $schedules]);
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
   
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        return response()->json(['schedule' => $schedule]);
    }

  
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->update([
            'slug' => $request->slug,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out
        ]);

        return response()->json(['message' => 'Schedule has been Updated successfully!'], 200);
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
