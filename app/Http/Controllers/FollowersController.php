<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowersController extends Controller
{
    public function follow(User $user)
    {
        if (!auth()->user()->is($user)) {
            auth()->user()->following()->toggle($user->id);
        }

        return back();
    }

    public function followers(User $user)
    {
        $followers = $user->followers;
        return view('users.followers', compact('followers'));
    }

    public function following(User $user)
    {
        $following = $user->following;
        return view('users.following', compact('following'));
    }
}
