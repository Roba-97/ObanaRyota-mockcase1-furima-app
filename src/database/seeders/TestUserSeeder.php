<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $profile = \App\Models\Profile::create([
            'user_id' => $user->id,
            'postcode' => '123-4567',
            'address' => '東京都新宿区テスト町1-1',
            'building' => 'テストビル101',
        ]);

        $favoriteItems = \App\Models\Item::orderBy('id')->take(3)->pluck('id')->toArray();
        foreach ($favoriteItems as $itemId) {
            \App\Models\Favorite::create([
                'user_id' => $user->id,
                'item_id' => $itemId,
            ]);
        }

        $purchasedItems = \App\Models\Item::orderBy('id')->skip(2)->take(2)->pluck('id')->toArray();
        foreach ($purchasedItems as $itemId) {
            \App\Models\Purchase::create([
                'buyer_id' => $user->id,
                'item_id' => $itemId,
                'payment' => 1,
                'delivery_postcode' => $profile->postcode,
                'delivery_address' => $profile->address . $profile->building,
            ]);
            \App\Models\Item::find($itemId)->update(['sold_flag' => true]);
        }

        $categoryIds = \App\Models\Category::whereIn('content', ['メンズ', 'アクセサリー'])->pluck('id')->toArray();
        $exhibitItem = \App\Models\Item::create([
            'seller_id' => $user->id,
            'condition_id' => 1,
            'image_path' => 'images/dummies/Armani+Mens+Clock.jpg',
            'name' => 'テスト出品商品',
            'price' => 3000,
            'detail' => 'これはテスト出品された商品です',
            'sold_flag' => false
        ]);
        $exhibitItem->categories()->sync($categoryIds);
    }
}
