<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\Event;
use App\Models\Period;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Support\Facades\Validator;

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
            'events' => $events,
            'periods' => Period::all(),
            'terms' => Term::all(),
        ]);
    }
    
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'start' => 'required',
                'end' => 'required',
                'category' => 'required|string',
                'week_id' => 'required',
            ]);

            if($validator->fails()){
                return response()->json([
                    "status" => false,
                    "message" => $validate->messages()->first()
                ], 500);
            }else{
                $event = Event::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'week_id'=>  $request->week_id,
                    'category' => $request->category,
                    'period_id' => period('id'),
                    'term_id'=>  term('id'),
                    'author_id' => auth()->user()->id()
                ]);
        
                return response()->json([ 'status' => true, 'data' => [
                                        'id' => $event->id,
                                        'start' => $event->start,
                                        'end' => $event->end,
                                        'title' => $event->title,
                                        'category' => $event->category,
                                ],
                    'message' => 'Event saved successfully!'
                ], 200);
            }

        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return response()->json($event);
    }

    public function update(Request $request)
    {
        $event = Event::findOrFail($request->event_id);

        $event->update([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'category' => $request->category,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Event updated successfully!'
        ], 200);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return response()->json([
            'status' => true,
            'message' => 'Event deleted successfully!'
        ], 200);
    }
}