<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Week;
use App\Models\Hairstyle;
use Illuminate\Http\Request;

class WeekController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin', 'auth']);
    }

    public function index()
    {
        $weeks = Week::with(['hairstyle', 'period', 'term'])->orderBy('start_date', 'asc')->paginate(20);
        return view('admin.weeks.index', compact('weeks'));
    }

    public function list(Request $request)
    {
        try {
            $query = Week::with(["hairstyle", 'period', 'term']);
            $perPage = $request->input('per_page', 20);
            $page = $request->input('page', 1);

            // Filter: start_date (from), end_date (to)
            if ($request->filled('start_date')) {
                $query->whereDate('start_date', '>=', $request->start_date);
            }
            if ($request->filled('end_date')) {
                $query->whereDate('end_date', '<=', $request->end_date);
            }

            // use Eloquent pagination for consistency
            $weeks = $query->orderBy('start_date', 'asc')->paginate($perPage);

            return response()->json([
                'status' => true,
                'data' => $weeks->items(),
                'total' => $weeks->total(),
                'page' => $weeks->currentPage(),
                'per_page' => $weeks->perPage(),
                'last_page' => $weeks->lastPage(),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function create()
    {
        return view('admin.weeks.create');
    }

    public function store(Request $request)
    {
        // We'll either generate weeks from term settings (resumption -> vacation) or use provided start/end
        try {
            $termSetting = termSetting(term('id'), period('id'));

            if ($termSetting && $termSetting->resumption_date && $termSetting->vacation_date) {
                $start = \Carbon\Carbon::parse($termSetting->resumption_date)->startOfDay();
                $end = \Carbon\Carbon::parse($termSetting->vacation_date)->endOfDay();
            } else {
                // require start/end from request
                $request->validate([
                    'start_date' => 'required|date',
                    'end_date' => 'required|date|after_or_equal:start_date',
                ]);
                $start = \Carbon\Carbon::parse($request->start_date)->startOfDay();
                $end = \Carbon\Carbon::parse($request->end_date)->endOfDay();
            }

            // iterate weeks from start to end and create Mon-Fri weeks
            $created = [];
            $cursor = $start->copy()->startOfWeek(); // startOfWeek() depends on locale; Monday is default in Carbon when startOfWeek called

            // get available hairstyle ids to randomly assign
            $hairstyleIds = Hairstyle::pluck('id')->toArray();
            $lastHairstyleId = null;

            while ($cursor->lessThanOrEqualTo($end)) {
                // define week start as Monday and end as Friday
                $weekStart = $cursor->copy()->startOfWeek();
                $weekEnd = $weekStart->copy()->addDays(4); // Monday + 4 => Friday

                // stop if week start is after end range
                if ($weekStart->greaterThan($end)) break;

                // clamp week end to provided end date
                if ($weekEnd->greaterThan($end)) {
                    $weekEnd = $end->copy();
                }

                // skip if a week with this start_date already exists (idempotency)
                if (Week::whereDate('start_date', $weekStart->toDateString())->exists()) {
                    $cursor->addWeek();
                    continue;
                }

                // pick a random hairstyle id, avoid duplicating the last week's hairstyle when possible
                $assignedHairstyleId = null;
                if (!empty($hairstyleIds)) {
                    // prefer ids not equal to last assigned
                    $available = array_values(array_diff($hairstyleIds, [$lastHairstyleId]));
                    if (empty($available)) {
                        // only possible when there's a single hairstyle available
                        $available = $hairstyleIds;
                    }
                    $assignedHairstyleId = $available[array_rand($available)];
                    $lastHairstyleId = $assignedHairstyleId;
                }

                $week = Week::create([
                    'start_date' => $weekStart->toDateString(),
                    'end_date' => $weekEnd->toDateString(),
                    'period_id' => period('id') ?? null,
                    'term_id' => term('id') ?? null,
                    'hairstyle_id' => $assignedHairstyleId,
                ]);

                $created[] = $week;

                // advance cursor by one week
                $cursor->addWeek();
            }

            return response()->json([
                'status' => true,
                'message' => 'Weeks created',
                'count' => count($created),
                'data' => $created,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'hairstyle_id' => 'nullable|exists:hairstyles,id',
            ]);

            $week = Week::findOrFail($id);
            $week->hairstyle_id = $request->input('hairstyle_id');
            $week->save();

            return response()->json(['status' => true, 'message' => 'Week updated', 'data' => $week], 200);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json(['status' => false, 'message' => $ve->getMessage()], 422);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }
}
