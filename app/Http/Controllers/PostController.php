<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Jobs\CreatePost;
use App\Jobs\UpdatePost;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('domain.post.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all()->pluck('name', 'id');
        return view('domain.post.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        // dd($request);
        $this->dispatchSync(CreatePost::fromRequest($request));

        $notification = array(
            'messege' => 'Post created successfully',
            'alert-type' => 'success',
            'title' => 'Successful!',
            'button' => 'Thanks, operation successful!',
        );
        
        return redirect()->route('post.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('domain.post.show', compact(['post']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        
        return view('domain.post.edit', [
            'post' => $post,
            'tags' => Tag::all(),
            'selectedTags'  => old('tags', $post->tags()->pluck('id')->toArray()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $this->dispatchSync(UpdatePost::fromRequest($post, $request));

        $notification = array(
            'messege' => 'Post updated successfully',
            'alert-type' => 'success',
            'title' => 'Successful!',
            'button' => 'Thanks, operation successful!',
        );
        
        return redirect()->route('post.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}