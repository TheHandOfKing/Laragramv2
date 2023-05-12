<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['user' => function ($query) {
            $query->select(['id', 'name', 'email', 'slug', 'username']); // Add any other relevant fields
        }])->get();

        $posts->each(function ($post) {
            $post->user->withoutMedia();
        });

        return Inertia::render('Dashboard', ['posts' => $posts]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $posts = $user->append('profilePicture')->posts()->with('media')->paginate(5);

        if (!$user) {
            return abort(404, 'User not found');
        }

        $pageTitle = $user->name . "(@" . $user->username . ")";
        $postsCount = $user->posts->count();
        $followCount = $user->following()->count();
        $followersCount = $user->followers()->count();

        return Inertia::render('Users/Show', ['user' => $user, 'posts' => $posts, 'pageTitle' => $pageTitle, 'postsCount' => $postsCount, 'followCount' => $followCount, 'followersCount' => $followersCount]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
