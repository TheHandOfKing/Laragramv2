<?php

namespace App\Services;

use App\Models\User;
use App\Models\Chat;

class ChatDataService
{
  /**
   * Get data of the other chatters for a given user.
   *
   * @param  User  $user
   * @return array
   */
  public function getOtherChattersData(User $user): array
  {
    $chats = $user->chats;

    $otherChattersData = [];
    foreach ($chats as $chat) {
      if ($chat->chatter_id === $user->id) {
        $otherChatter = User::find($chat->other_chatter_id);
      } else {
        $otherChatter = User::find($chat->chatter_id);
      }

      if ($otherChatter) {
        $otherChattersData[] = $otherChatter->toArray();
      }
    }

    return $otherChattersData;
  }
}
