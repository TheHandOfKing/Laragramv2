<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateChatRequest;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
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
    public function store(CreateChatRequest $request)
    {

        $chat = new Chat;
        $chat->chatter_id = auth()->user()->id; // The ID of the logged in user
        $chat->other_chatter_id = $request->other_chatter_id; // The ID of the user to chat with
        $chat->save();

        return response()->json([
            'message' => 'Chat started successfully.',
            'chat' => $chat
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
