<?php

namespace App\Http\Controllers;

use App\Events\Chat;
use App\Events\NewMessage;
use App\Models\Message;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MessagingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chats = auth()->user()->chats()
            ->with([
                'receiver' => function ($query) {
                    $query->select('id', 'username');
                },
                'messages' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                }
            ])->get();

        return Inertia::render('Messages/Dashboard', ['chats' => $chats]);
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
        $message = Message::create([
            'from_id' => auth()->id(),
            'to_id' => $request->receiver_id,
            'message' => $request->text_message
        ]);

        broadcast(new NewMessage($message));

        return response()->json($message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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


    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        $user->messages()->create([
            'message' => $request->input('message')
        ]);

        return ['status' => 'Message Sent!'];
    }

    public function searchUsers(Request $request)
    {
    }
}
