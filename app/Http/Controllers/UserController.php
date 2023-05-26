<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('search');

        $userId = auth()->id();

        $followers = auth()->user()->followers();

        $followersResults = $followers->where('followers.user_id', '!=', $userId)->doesntHave('roles', 'and', function ($query) {
            $query->where('name', 'admin');
        })->where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('username', 'LIKE', '%' . $query . '%')
                ->orWhere('name', 'LIKE', '%' . $query . '%');
        })->get();

        $otherUsersResults = User::where('users.id', '!=', $userId)->doesntHave('roles', 'and', function ($query) {
            $query->where('name', 'admin');
        })->whereNotIn('users.id', $followers->pluck('user_id'))
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('username', 'LIKE', '%' . $query . '%')
                    ->orWhere('name', 'LIKE', '%' . $query . '%');
            })->get();

        $results = $followersResults->concat($otherUsersResults);

        return $results;
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
    public function show(string $id)
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
