<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatMessageRequest;
use App\Models\ChatRoom;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatMessageController extends Controller
{
    public function create(ChatMessageRequest $request, ChatRoom $chatRoom)
    {
        $content = $request->input('content');
        if ($content) {
            Message::create([
                'chat_room_id' => $chatRoom->id,
                'sender_id' => Auth::user()->id,
                'content_type' => 1,
                'content' => $content,
            ]);
        }
        return redirect("/chat/$chatRoom->id");
    }

    public function update(ChatMessageRequest $request, Message $message)
    {
        $chatRoomId = $message->chatRoom->id;
        $message->update(['content' => $request->content]);
        return redirect("/chat/$chatRoomId");
    }

    public function delete(Message $message)
    {
        $chatRoomId = $message->chatRoom->id;
        $message->delete();
        return redirect("/chat/$chatRoomId");
    }
}
