<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Scopes\HasActiveScope;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct()
    {
        return $this->middleware(['auth', 'admin'])->except(['allNews']);
    }

    public function index()
    {
        $news = News::with(['period', 'term'])->withoutGlobalScope(new HasActiveScope)->orderBy('created_at', 'desc')->get();
        return response()->json(['status' => true, 'news' => $news], 200);
    }

    public function store(Request $request)
    {
        try {
            $news = News::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'category' => $request->category,
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
        try {
            $news = News::withoutGlobalScope(new HasActiveScope)->where('id', $id)->first();
            if (!$news) {
                return response()->json(['status' => false, 'message' => 'News not found.'], 404);
            }

            $news->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'category' => $request->category
            ]);

            return response()->json(['status' => true, 'message' => 'News updated successfully!'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $news = News::withoutGlobalScope(new HasActiveScope)->where('id', $id)->first();
            if (!$news) {
                return response()->json(['status' => false, 'message' => 'News not found.'], 404);
            }

            $news->delete();
            return response()->json(['status' => true, 'message' => 'News deleted successfully.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    public function allNews()
    {
        $newsData = News::withoutGlobalScope(new HasActiveScope)->orderBy('created_at', 'desc')->get();
        $news = [];
        foreach ($newsData as $item) {
            $news[] = [
                'title' => $item->title,
                'description' => $item->description,
            ];
        }

        return response()->json(['status' => true, 'news' => $news], 200);
    }
}
