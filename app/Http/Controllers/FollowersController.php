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
}
