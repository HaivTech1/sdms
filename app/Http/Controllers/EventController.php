<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\Event;
use App\Models\Period;
use Illuminate\Http\Request;
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

    public function list(Request $request)
    {
        try {
            $query = Event::query();
            $perPage = $request->input('per_page', 20);
            $page = $request->input('page', 1);

            // Filter: start_date (from), end_date (to)
            if ($request->filled('start_date')) {
                $query->whereDate('start_date', '>=', $request->start_date);
            }
            if ($request->filled('end_date')) {
                $query->whereDate('end_date', '<=', $request->end_date);
            }

            // Filter: category
            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            // Filter: title (partial match)
            if ($request->filled('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }

            $events = $query->orderByDesc('start_date')->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'status' => true,
                'events' => $events
            ]);
        } catch (\Throwable $th) {
            info($th);
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }
    
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'description' => 'required|string',
                'start_date' => 'required',
                'end_date' => 'required',
                'category' => 'required|string',
                'period_id' => ['required'],
                'term_id' => ['required'],
            ]);

            if($validator->fails()){
                return response()->json([
                    "status" => false,
                    "message" => $validator->errors()->toArray()
                ], 500);
            }

            Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'category' => $request->category,
                'period_id' => $request->period_id,
                'term_id'=> $request->term_id,
                'author_id' => auth()->id()
            ]);
        
            return response()->json([ 'status' => true, 'message' => 'Event saved successfully!'], 200);

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
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'category' => $request->category,
            'period_id' => $request->period_id,
            'term_id' => $request->term_id,
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