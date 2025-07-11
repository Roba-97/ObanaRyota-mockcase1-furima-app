<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;

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

    public function messages() {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function dealingItems() {
        $soldItemsQuery = $this->items()->where('sold_flag', true)->select('id');
        $purchasedItemsQuery = $this->purchases()->select('item_id');

        return Item::whereIn('id', $soldItemsQuery)
            ->orWhereIn('id', $purchasedItemsQuery)
            ->get();
    }

    public function updateRating($newRating)
    {
        $profile = $this->profile;

        // 合計点数と合計回数を更新
        $newSum = $profile->rating_sum + $newRating;
        $newCount = $profile->rating_count + 1;

        // 新しい平均値を計算
        $newAverage = $newSum / $newCount;

        // データベースを更新
        $profile->update([
            'average_rating' => $newAverage,
            'rating_count' => $newCount,
            'rating_sum' => $newSum,
        ]);
    }
}
