<?php

namespace App\Http\Controllers;

use App\Http\Resources\v1\EventResource;
use App\Models\Term;
use App\Models\Event;
use App\Models\Period;
use App\Jobs\SendEventNotificationJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
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
            $query = Event::with(['period', 'term']);
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
            $data = $request->all();
            $validator = Validator::make($data, [
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

            $event = Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'time' => $request->time,
                'category' => $request->category,
                'period_id' => $request->period_id,
                'term_id'=> $request->term_id,
                'author_id' => auth()->id()
            ]);

            return response()->json([ 'status' => true, 'message' => 'Event saved successfully!', 'event' =>
            new EventResource($event)], 200);

        } catch (\Throwable $th) {
            info($th);
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
            'time' => $request->time,
            'category' => $request->category,
            'period_id' => $request->period_id,
            'term_id' => $request->term_id,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Event updated successfully!'
        ], 200);
    }

    public function delete($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return response()->json([
            'status' => true,
            'message' => 'Event deleted successfully!'
        ], 200);
    }

    public function notify($id)
    {
        $event = Event::findOrFail($id);

        $batch = Bus::batch([
            new SendEventNotificationJob($event->id)
        ])->name('event_notification_' . $event->id)
          ->dispatch();

        return response()->json([
            'status' => true,
            'message' => 'Notification batch dispatched',
            'batch_id' => $batch->id,
        ], 200);
    }

    public function batchView($batchId)
    {
        return view('admin.event.batch', ['batchId' => $batchId]);
    }

    public function getBatchInfo($batchId)
    {
        try {
            $batch = Bus::findBatch($batchId);
            if (! $batch) {
                return response()->json(['status' => false, 'message' => 'Batch not found'], 404);
            }

            return response()->json(['status' => true, 'batch' => [
                'id' => $batch->id,
                'name' => $batch->name,
                'total_jobs' => $batch->totalJobs,
                'pending' => $batch->pendingJobs,
                'failed' => $batch->failedJobs,
                'processed' => $batch->processedJobs,
                'cancelled' => $batch->cancelledJobs,
                'finished' => $batch->finished(),
                'created_at' => $batch->createdAt,
                'finished_at' => $batch->finishedAt,
            ]]);
        } catch (\Throwable $th) {
            info($th);
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function sendNotificationToParents(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        $subject = 'Event: ' . ($event->title ?? 'School Event');
        $body = $event->description ?? '';
        $watMessage = $subject . "\n" . strip_tags($body);

        // Optional grade filter: pass grade_ids as an array in the request to limit targets.
        $gradeIds = $request->input('grade_ids');

        if (is_array($gradeIds) && count($gradeIds) > 0) {
            $students = \App\Models\Student::whereIn('grade_id', $gradeIds)->get();
        } else {
            // No grades provided: notify all students' parents
            $students = \App\Models\Student::all();
        }

        foreach ($students as $student) {
            try {
                dispatch(new \App\Jobs\NotifyParentsJob($student, $body, $subject, null, $eventId));
                dispatch(new \App\Jobs\SendWhatsappJob($student, $watMessage, 'parent', $eventId));
            } catch (\Exception $e) {
                info('sendNotificationToParents error: ' . $e->getMessage());
            }
        }

        return response()->json(['status' => true, 'message' => 'Notifications queued']);
    }
}