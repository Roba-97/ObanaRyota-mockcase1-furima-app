<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use Nette\Utils\Strings;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'seller_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'buyer_id');
    }

    public function chatRooms()
    {
        return $this->belongsToMany(ChatRoom::class, 'chat_room_user')->withPivot('last_accessed_at')->withTimestamps();
    }

    public function messages() {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function dealingItems() {
        $soldItemsQuery = $this->items()->where('sold_flag', true)->select('id');
        $purchasedItemsQuery = $this->purchases()->select('item_id');

        $dealingItems = Item::whereIn('id', $soldItemsQuery)
            ->orWhereIn('id', $purchasedItemsQuery)
            ->with('chatRoom.participants')
            ->get();

        $user = $this;
        $filteredItems = $dealingItems->filter(function ($item) use ($user) {
            // ステータスが1以上 かつ ユーザーが購入者
            $filter1 = $item->chatRoom->status >= 1 && $item->chatRoom->isBuyer($user);
            // ステータスが2以上 かつ ユーザーが販売者
            $filter2= $item->chatRoom->status >= 2 && $item->chatRoom->isSeller($user);

            return !$filter1 && !$filter2;
        });

        return $filteredItems;
    }

    public function updateRating($newRating)
    {
        $profile = $this->profile;

        $newSum = $profile->rating_sum + $newRating;
        $newCount = $profile->rating_count + 1;
        $newAverage = $newSum / $newCount;

        $profile->update([
            'rating_average' => $newAverage,
            'rating_count' => $newCount,
            'rating_sum' => $newSum,
        ]);
    }

    public function haveDraftOn(ChatRoom $chatRoom)
    {
        if(session()->exists('chat_drafts.' . $chatRoom->id)
            && session()->get('chat_drafts.' . $chatRoom->id)["user_id"] === $this->id
        ) {
            return session()->get('chat_drafts.' . $chatRoom->id)["draft"];
        }

        return null;
    }
}
