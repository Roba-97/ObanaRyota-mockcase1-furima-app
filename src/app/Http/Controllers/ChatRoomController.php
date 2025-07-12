<?php

namespace App\Http\Controllers;

use App\Mail\DealNotification;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        $user = Auth::user();
        $ratedUser = $chatRoom->getOtherParticipant($user);

        $ratedUser->updateRating($request->input('rate'));

        if($chatRoom->isBuyer($user)) {
            Mail::to($ratedUser)->send(new DealNotification($chatRoom, $user));
        }

        return redirect('/');
    }
}
