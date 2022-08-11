<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\PostResource;
use App\Http\Resources\v1\PostCollection;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageSize = $request->page ?? 5;
        $limit = $request->limit ?? 5;
        return new PostCollection(Post::get());
    }

    public function show(Post $post)
    {
        return (new PostResource($post))
        ->response()
        ->setStatusCode(200);
    }
}