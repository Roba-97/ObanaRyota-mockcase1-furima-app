<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'status'
    ];

    public function purchase() {
        return $this->belongsTo(Purchase::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }

    public function participants() {
        return $this->belongsToMany(User::class, 'chat_room_user')->withPivot('last_accessed_at')->withTimestamps();
    }

    public function isBuyer(User $currentUser) {
        return $currentUser->is($this->purchase->buyer);
    }

    public function isSeller(User $currentUser) {
        return $currentUser->is($this->purchase->item->seller);
    }

    public function getOtherParticipant(User $currentUser)
    {
        $seller = $this->purchase->item->seller;
        $buyer = $this->purchase->buyer;

        if ($currentUser->is($buyer)) {
            return $seller;
        }

        if ($currentUser->is($seller)) {
            return $buyer;
        }

        return null;
    }

    public function getNotificationCount(User $currentUser)
    {
        $chatRoomId = $this->id;
        $last_accessed_at = null;

        foreach($this->participants as $participant) {
            if($participant->pivot->user_id === $currentUser->id && $participant->pivot->chat_room_id === $chatRoomId) {
                $last_accessed_at = $participant->pivot->last_accessed_at;
                break;
            }
        }

        if ($last_accessed_at === null) {
            return $this->messages->count();
        }

        return $this->messages
            ->where('created_at', '>', $last_accessed_at)
            ->where('sender_id', '!=', $currentUser->id)
            ->count();
    }
}
