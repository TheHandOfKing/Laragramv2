<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        if ($request->validated()) {
            $post = new Post();
            $post->setValues();

            return response()->json([
                'status' => 200,
                'message' => 'Post created successfily',
                'post' => $post
            ]);
        }

        return response()->json([
            'status' => 500,
            'message' => 'Post not created, something went wrong',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $user = $post->user;
        $pageTitle = "Post from @" . $user->username;
        $media = $post->getMedia('post-image');
        $comments = $post->comments()->where('parent_id', null)->with('children')->get();

        return Inertia::render('Posts/Show', ['user' => $user, 'post' => $post, 'pageTitle' => $pageTitle, 'media' => $media, "comments" => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
