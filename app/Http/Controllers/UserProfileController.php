<?php

namespace App\Http\Controllers;

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
        return Inertia::render('Dashboard');
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
    public function show(Request $request, $slug)
    {
        $user = User::where('slug', $slug)->first()->append('profilePicture');

        $posts = $user->posts()->with('media')->paginate(5);

        if (!$user) {
            return abort(404, 'User not found');
        }

        $pageTitle = $user->name . "(@" . $user->username . ")";
        $postsCount = $user->posts->count();

        return Inertia::render('Users/Show', ['user' => $user, 'posts' => $posts, 'pageTitle' => $pageTitle, 'postsCount' => $postsCount]);
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
