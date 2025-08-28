<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct()
    {
        return $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $news = News::with('author')->latest()->get();
        return response()->json(['status' => true, 'news' => $news], 200);
    }

    public function store(Request $request)
    {
        $status = $request->get('status') === 'on' ? 1 : 0;
        try {
            $news = News::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $status,
                'period_id' => period('id'),
                'term_id' => term('id'),
                'author_id' => auth()->id()
            ]);

            if ($news) {
                return response()->json(['status' => true, 'message' => 'News created successfully!'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $status = $request->get('status') === 'on' ? 1 : 0;
        try {
            $news = News::find($id);
            if (!$news) {
                return response()->json(['status' => false, 'message' => 'News not found.'], 404);
            }

            $news->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $status,
            ]);

            return response()->json(['status' => true, 'message' => 'News updated successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $news = News::find($id);
            if (!$news) {
                return response()->json(['status' => false, 'message' => 'News not found.'], 404);
            }

            $news->delete();
            return response()->json(['status' => true, 'message' => 'News deleted successfully.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }
}
