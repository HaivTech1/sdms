<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Week;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use App\Models\CurriculumTopic;
use App\Http\Controllers\Controller;
use App\Jobs\NotifyParentsJob;
use App\Models\Question;
use Illuminate\Support\Facades\Validator;

class CurriculumController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            $query = Curriculum::with(['grade','subject','period','term']);

            if (!($user->isAdmin() || $user->isSuperAdmin())) {
                $query->where('author_id', $user->id);
            }

            if ($request->filled('search')) {
                $q = $request->get('search');
                $query->where('name', 'like', "%{$q}%");
            }

            $curriculums = $query->orderBy('id','desc')->paginate(20);

            return response()->json([
                'status' => true,
                'curriculums' => $curriculums,
            ], 200);
        } catch (\Throwable $th) {
            info($th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch curriculum data. Please try again.',
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'grade_id' => 'required|exists:grades,id',
                'subject_id' => 'required|exists:subjects,id',
                'period_id' => 'required|exists:periods,id',
                'term_id' => 'required|exists:terms,id',
                'description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $curriculum = Curriculum::create(collect($request->only(['name','grade_id','subject_id','period_id','term_id','description']))->toArray());
            $curriculum->authoredBy(auth()->user());
            $curriculum->save();

            return response()->json([
                'status' => true,
                'message' => 'Curriculum created successfully!',
                'curriculum' => $curriculum,
            ], 201);
        } catch (\Throwable $th) {
            info($th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to create curriculum. Please try again.',
            ], 500);
        }
    }

    public function update(Request $request, Curriculum $curriculum)
    {
        try {
            $user = auth()->user();
            if (!($user->isAdmin() || $curriculum->isAuthoredBy($user))) {
                return response()->json([
                    'status' => false,
                    'message' => 'You are not authorized to perform this action.',
                ], 403);
            }

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $curriculum->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Curriculum updated successfully!',
                'curriculum' => $curriculum,
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            info($th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to update curriculum. Please try again.',
            ], 500);
        }
    }

    public function destroy(Curriculum $curriculum)
    {
        try {
            $user = auth()->user();
            if (!($user->isAdmin() || $curriculum->isAuthoredBy($user))) {
                return response()->json([
                    'status' => false,
                    'message' => 'You are not authorized to perform this action.',
                ], 403);
            }

            $curriculum->delete();

            return response()->json([
                'status' => true,
                'message' => 'Curriculum deleted successfully!',
            ], 200);
        
        } catch (\Throwable $th) {
            info($th->getMessage());
            return response()->json([   
                'status' => false,
                'message' => 'Failed to delete curriculum. Please try again.',
            ], 500);
        }
    }

    public function topics(Curriculum $curriculum)
    {
        try {
            $user = auth()->user();
            if (!($user->isAdmin() || $curriculum->isAuthoredBy($user))) {
                abort(403);
            }

            $topics = $curriculum->topics()->with('week')->withCount('questions')->orderBy('week_id')->paginate(25);

            return response()->json([
                'status' => true,
                'topics' => $topics,
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            info($th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch topics. Please try again.',
            ], 500);
        }
    }

    public function addTopic(Request $request, Curriculum $curriculum)
    {
        try {
            $user = auth()->user();
            if (!($user->isAdmin() || $curriculum->isAuthoredBy($user))) {
                return response()->json([
                    'status' => false,
                    'message' => 'You are not authorized to perform this action.',
                ], 403);
            }

            $data = $request->validate([
                'week_id' => 'required|exists:weeks,id',
                'title' => 'required|string|max:255',
                'objectives' => 'nullable|string',
                'bloom_level' => 'nullable|string',
                'resources' => 'nullable|string',
                'test_duration' => 'nullable|integer|min:5|max:180',
            ]);

            $data['curriculum_id'] = $curriculum->id;
            $data['author_id'] = $user->id;

            $topic = CurriculumTopic::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Topic added successfully!',
                'topic' => $topic,
            ], 201);
        } catch (\Throwable $th) {
            //throw $th;
            info($th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to add topic. Please try again.',
            ], 500);
        }
    }

    public function updateTopic(Request $request, Curriculum $curriculum, CurriculumTopic $topic)
    {
        try {
            $user = auth()->user();
            if (!($user->isAdmin() || $curriculum->isAuthoredBy($user) && $topic->isAuthoredBy($user))) {
                return response()->json([
                    'status' => false,
                    'message' => 'You are not authorized to perform this action.',
                ], 403);
            }

            $data = $request->validate([
                'week_id' => 'required|exists:weeks,id',
                'title' => 'required|string|max:255',
                'objectives' => 'nullable|string',
                'bloom_level' => 'nullable|string',
                'resources' => 'nullable|string',
                'test_duration' => 'nullable|integer|min:5|max:180',
            ]);

            $topic->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Topic updated successfully!',
                'topic' => $topic,
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            info($th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to update topic. Please try again.',
            ], 500);
        }
    }

    public function deleteTopic(Curriculum $curriculum, CurriculumTopic $topic)
    {
        try {
            $user = auth()->user();
            if (!($user->isAdmin() || $curriculum->isAuthoredBy($user) && $topic->isAuthoredBy($user))) {
                return response()->json([
                    'status' => false,
                    'message' => 'You are not authorized to perform this action.',
                ], 403);
            }

            $topic->delete();
            return response()->json([
                'status' => true,
                'message' => 'Topic deleted successfully!',
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            info($th->getMessage());
            return response()->json([   
                'status' => false,
                'message' => 'Failed to delete topic. Please try again.',
            ], 500);
        }
    }

    public function questions(Curriculum $curriculum, CurriculumTopic $topic)
    {
        try {
            $user = auth()->user();
            if (!($user->isAdmin() || $curriculum->isAuthoredBy($user))) abort(403);

            $questions = Question::where('curriculum_topic_id', $topic->id)->orderBy('id','desc')->get();

            return response()->json([
                'status' => true,
                'questions' => $questions
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            info($th->getMessage());
            return response()->json([   
                'status' => false,
                'message' => 'Failed to fetch topics. Please try again.',
            ], 500);
        }
    }

    public function notify(CurriculumTopic $topic)
    {
        try {
            // Notify users about the curriculum update
            // NotifyParentsJob::dispatch($users, new CurriculumUpdated($topic));

            return response()->json([
                'status' => true,
                'message' => 'Users notified successfully.',
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            info($th->getMessage());
            return response()->json([   
                'status' => false,
                'message' => 'Failed to fetch topics. Please try again.',
            ], 500);
        }
    }
}
