<?php

namespace App\Repositories;

use App\Http\Requests\CreateChatRequest;
use App\Models\Chat;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class ChatRepository
{
	public function createChat(CreateChatRequest $request): JsonResponse
	{
		$other_chatter = $request->other_chatter_id;
		$user_id = auth()->user()->id;
		$chat = Chat::where('chatter_id', $user_id)->where('other_chatter_id', $other_chatter)->get();

		if ($chat->count() > 0) {
			return response()->json([
				'message' => 'Chat already exists.',
				'action' => 'redirect_to_chat',
				'chat_id' => $chat->first()->id,
			]);
		}

		$new_chat = $this->create($user_id, $other_chatter);

		return response()->json([
			'message' => 'Chat started successfully.',
			'action' => 'redirect_to_chat',
			'chat' => $new_chat
		]);
	}

	private function create(int $user_id, int $other_chatter)
	{
		$chat = new Chat;
		$chat->chatter_id = $user_id; // The ID of the logged in user
		$chat->other_chatter_id = $other_chatter; // The ID of the user to chat with
		$chat->save();
	}
}
