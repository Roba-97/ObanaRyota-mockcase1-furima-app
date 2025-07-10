<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;

class ChatRoomController extends Controller
{
    public function index(ChatRoom $chatRoom)
    {
        $messages = $chatRoom->messages()->get();
        return view("chat", compact('chatRoom', 'messages'));
    }
}
