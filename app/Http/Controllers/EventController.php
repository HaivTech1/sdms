<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\Event;
use App\Models\Period;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $events = array();
        $schoolEvents = Event::all();
        $schoolEvents = Event::all();
        foreach($schoolEvents as $school) {
            $events[] = [
                'groupId' => $school->id(),
                'title' => $school->title(),
                'start' => $school->start(),
                'end' => $school->end(),
                'className' => $school->category(),
            ];
        }
        return view('admin.event.index',[
            'events' => $events
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string'
        ]);

        $event = Event::create([
            'title' => $request->title,
            'start' => $request->start_date,
            'end' => $request->end_date,
            'category' => $request->n,
            'period_id' => Period::whereStatus(1)->pluck('id')[0],
            'term_id'=> Term::whereStatus(1)->pluck('id')[0],
            'author_id' => auth()->user()->id()
        ]);

        return response()->json([ 'status' => 'success', 'data' => [
                                                            'id' => $event->id,
                                                            'start' => $event->start,
                                                            'end' => $event->end,
                                                            'title' => $event->title,
                                                            'category' => $event->category,
                                                        ],
                                    'message' => 'Event saved successfully'
                                ]);
    }
    public function update(Request $request ,$id)
    {
        $event = Event::findOrFail($id);

        $event->update([
            'title' => $request->title,
            'start' => $request->start_date,
            'end' => $request->end_date,
            'category' => $request->category,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Event deleted successfully!'
        ], 200);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Event deleted successfully!'
        ], 200);
    }
}