<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
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

    public function store(StoreCommentRequest $request)
    {
        $post = Post::find($request->post_id);
        $comment = new Comment([
            'body' => $request->input('body'),
            'user_id' => Auth::id(),
        ]);

        $post->comments()->save($comment);

        if ($request->has('parent_id')) {
            $parent = Comment::find($request->input('parent_id'));
            $comment->parent()->associate($parent);
        }

        $comment->save();
        dd($comment);
        return response()->json([
            'status' => 'success',
            'message' => 'Comment added successfully!',
            'comment' => $comment,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->back()->with('status', 'Comment deleted successfully!');
    }
}
