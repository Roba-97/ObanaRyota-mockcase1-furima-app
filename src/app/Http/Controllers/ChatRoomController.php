<?php

namespace App\Http\Controllers;

use App\Mail\DealNotification;
use App\Models\ChatRoom;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ChatRoomController extends Controller
{
    public function index(ChatRoom $chatRoom)
    {
        $chatRoom->participants()->updateExistingPivot(Auth::user()->id, [
            'last_accessed_at' => Carbon::now(),
        ]);

        $activeChatRoomId = $chatRoom->id;
        $partitionedItems = Auth::user()->dealingItems()->partition(function ($item) use ($activeChatRoomId) {
            return $item->chatRoom->id === $activeChatRoomId;
        });
        $sortedInactiveItems = $partitionedItems[1]->sortByDesc(function ($item) {
            return optional($item->chatRoom->messages()->latest()->first())->created_at;
        });
        $dealingItems = $partitionedItems[0]->merge($sortedInactiveItems);

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

        return redirect('/mypage?page=deal');
    }
}
