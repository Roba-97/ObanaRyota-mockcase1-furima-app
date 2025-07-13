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

        if($chatRoom->isBuyer($user) && $chatRoom->status === 0) {
            $ratedUser->updateRating($request->input('rate'));
            Mail::to($ratedUser)->send(new DealNotification($chatRoom, $user));
            $chatRoom->update(['status' => 1]);
        }

        if($chatRoom->isSeller($user) && $chatRoom->status === 1) {
            $ratedUser->updateRating($request->input('rate'));
            $chatRoom->update(['status' => 2]);
        }

        return redirect('/');
    }
}
