<?php

namespace App\Http\Controllers\API\v1;

use App\Models\{
    Term,
    User,
    Grade,
    Period,
    Subject,
    Application,
    Club,
    House,
    News,
    Permission,
    Role,
    Schedule
};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\TermResource;
use App\Http\Resources\v1\GradeResource;
use App\Http\Resources\v1\SessionResource;
use App\Http\Resources\v1\SettingResource;
use App\Http\Resources\v1\SubjectResource;
use App\Scopes\ExcludeLastRecordService;
use App\Scopes\HasActiveScope;

class SettingController extends Controller
{
    public function index()
    {
        $application = new SettingResource(Application::first());

        try {
            return response()->json(['status' => true, 'settings' => $application], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'errors' => $th->getMessage()], 500);
        }
    }

    public function grade()
    {
        $user = auth()->user();

        $query = Grade::withoutGlobalScope(new ExcludeLastRecordService);

        if (! $user || (!method_exists($user, 'isAdmin') || (! $user->isAdmin() && ! (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin())))) {
            $query->whereNotIn('title', ['Testing', 'Graduated']);
        }

        $data = $query->get();
        $grades = GradeResource::collection($data);
        return response()->json(['status' => 200, 'grades' => $grades], 200);
    }

    public function session()
    {
        $data = Period::all();
        $sessions = SessionResource::collection($data);
        return response()->json(['status' => 200, 'sessions' => $sessions], 200);
    }

    public function term()
    {
        $data = Term::all();
        $terms = TermResource::collection($data);
        return response()->json(['status' => 200, 'terms' => $terms], 200);
    }

    public function subject()
    {
        $data = Subject::all();
        $subjects = SubjectResource::collection($data);
        return response()->json(['status' => 200, 'subjects' => $subjects], 200);
    }

    public function houses()
    {
        $data = House::where('status', true)->get();
        $houses = [];
        foreach ($data as $value) {
            $houses[] = [
                'id' => $value->id,
                'title' => $value->title,
            ];
        }
        return response()->json(['status' => 200, 'houses' => $houses], 200);
    }

    public function clubs() 
    {
        $data = Club::where('status', true)->get();
        $clubs = [];
        foreach ($data as $value) {
            $clubs[] = [
                'id' => $value->id,
                'title' => $value->slug,
            ];
        }
        return response()->json(['status' => 200, 'clubs' => $clubs], 200);
    }

    public function schedules()
    {
        $data = Schedule::get();
        $schedules = [];
        foreach ($data as $value) {
            $schedules[] = [
                'id' => $value->id,
                'title' => $value->title,
            ];
        }
        return response()->json(['status' => 200, 'schedules' => $schedules], 200);
    }

    public function midtermFormat()
    {
        try {
            $midterm = get_settings('midterm_format');
            return response()->json(['midterm' => $midterm], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function examFormat()
    {
        try {
            $exam = get_settings('exam_format');
            return response()->json(['exam' => $exam], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getSiteRoles()
    {
        try {

            $roles = Role::all();

            return response()->json([
                'status' => true,
                'roles' => $roles,
                'count' => count($roles)
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(ApiResponse(500, "There was an error fetching the roles."), 500);
        }
    }

    public function getSitePermissions()
    {
        try {
            $permissions = Permission::all();
            return response()->json([
                'status' => true,
                'permissions' => $permissions,
                'count' => count($permissions)
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(ApiResponse(500, "There was an error fetching the permissions."), 500);
        }
    }

    public function getRolePermissions($id)
    {
        try {

            $user = User::where('id', $id)->first();
            $permissions = $user->roles[0]->permissions;

            return response()->json([
                'status' => true,
                'role_permissions' => $permissions,
                'count' => count($permissions)
            ], 200);

        } catch (\Throwable $th) {
            info($th->getMessage());
            return response()->json(ApiResponse(500, "There was an error fetching the role permissions."), 500);
        }
    }

    public function dashboardSummary(Request $request)
    {
        try {
            $periodId = (int) ($request->query('period_id'));
            $termId   = (int) ($request->query('term_id'));
            $gradeId  = (int) ($request->query('grade_id'));

            // Active students
            $studentIds = \App\Models\Student::query()
                ->where('status', 1)
                ->whereHas('grade', fn ($sq) => $sq->where('id', $gradeId))
                ->pluck('uuid');

            $totalExamPublished     = 0;
            $totalExamPending       = 0;
            $totalMidtermPublished  = 0;
            $totalMidtermPending    = 0;
            $totalRegistrations = 0;

            // --- Exams (PrimaryResult) ---
            $examQuery = \App\Models\PrimaryResult::query()
                ->when($studentIds->isNotEmpty(), fn($q) => $q->whereIn('student_id', $studentIds))
                ->when($periodId, fn($q) => $q->where('period_id', $periodId))
                ->when($termId, fn($q) => $q->where('term_id', $termId))
                ->when($gradeId, fn($q) => $q->where('grade_id', $gradeId));

            $resultsByStudent = $examQuery->select('student_id')
                ->selectRaw("SUM(CASE WHEN published = 1 THEN 1 ELSE 0 END) as published_count")
                ->selectRaw("COUNT(*) as total_count")
                ->groupBy('student_id')
                ->get();

            foreach ($resultsByStudent as $row) {
                if ($row->published_count == $row->total_count) {
                    $totalExamPublished++;
                } else {
                    $totalExamPending++;
                }
            }

            // --- Midterms (Midter) ---
            $midtermQuery = \App\Models\MidTerm::query()
                ->when($studentIds->isNotEmpty(), fn($q) => $q->whereIn('student_id', $studentIds))
                ->when($periodId, fn($q) => $q->where('period_id', $periodId))
                ->when($termId, fn($q) => $q->where('term_id', $termId))
                ->when($gradeId, fn($q) => $q->where('grade_id', $gradeId));

            $midtermsByStudent = $midtermQuery->select('student_id')
                ->selectRaw("SUM(CASE WHEN published = 1 THEN 1 ELSE 0 END) as published_count")
                ->selectRaw("COUNT(*) as total_count")
                ->groupBy('student_id')
                ->get();

            foreach ($midtermsByStudent as $row) {
                if ($row->published_count == $row->total_count) {
                    $totalMidtermPublished++;
                } else {
                    $totalMidtermPending++;
                }
            }

            // --- General summary ---
            $totalStudents = \App\Models\User::whereType(4)
            ->where('isAvailable', true)
            ->whereHas('student', function ($q) use ($gradeId) {
                $q->whereHas('grade', function ($g) use ($gradeId) {
                    $g->whereNotIn('title', ['Testing', 'Graduated']);
                    if ($gradeId) {
                        $g->where('id', $gradeId);
                    }
                });
            })
            ->count();


            $totalTeachers = \App\Models\User::whereType(3)->where('isAvailable', true)->count();
            $totalWorkers  = \App\Models\User::whereType(6)->where('isAvailable', true)->count();
            $totalStaffs   = \App\Models\User::whereIn('type', [3, 5, 6])->where('isAvailable', true)->count();
            $totalNews     = \App\Models\News::where('status', true)->count();
            $totalRegistrations = \App\Models\Registration::withoutGlobalScope(new HasActiveScope)->where('status', false)->count();


            return response()->json([
                'status'  => true,
                'summary' => [
                    'totalStudents'         => $totalStudents,
                    'totalTeachers'         => $totalTeachers,
                    'totalWorkers'          => $totalWorkers,
                    'totalStaffs'           => $totalStaffs,
                    'totalNews'             => $totalNews,
                    'totalExamPublished'    => $totalExamPublished,
                    'totalExamPending'      => $totalExamPending,
                    'totalMidtermPublished' => $totalMidtermPublished,
                    'totalMidtermPending'   => $totalMidtermPending,
                    'totalRegistrations' => $totalRegistrations
                ],
            ], 200);

        } catch (\Throwable $th) {
            \Log::error($th);
            return response()->json([
                'status'  => false,
                'message' => 'There was an error fetching the dashboard summary.',
                'error'   => $th->getMessage(),
            ], 500);
        }
    }
}
