<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatRoomController extends Controller
{
    public function index(ChatRoom $chatRoom)
    {
        $dealingItems = Auth::user()->dealingItems();
        $messages = $chatRoom->messages()->get();

        return view("chat", compact('chatRoom', 'dealingItems', 'messages'));
    }

    public function rateUser(ChatRoom $chatRoom, Request $request)
    {
        $ratedUser = $chatRoom->getOtherParticipant(Auth::user());
        $ratedUser->updateRating($request->input('rate'));

        return redirect('/');
    }
}
