<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'status',
        'last_accessed_at'
    ];

    public function purchase() {
        return $this->belongsTo(Purchase::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }

    public function getOtherParticipant(User $currentUser)
    {
        // ChatRoomに紐づくPurchaseから出品者と購入者を取得
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

    public function isBuyer(User $currentUser)
    {
        return $currentUser->is($this->purchase->buyer);
    }

    public function isSeller(User $currentUser)
    {
        return $currentUser->is($this->purchase->item->seller);
    }
}
