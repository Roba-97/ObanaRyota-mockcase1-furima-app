<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\User;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'Test User1',
            'email' => 'test1@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        Profile::create([
            'user_id' => $user1->id,
            'postcode' => '123-4567',
            'address' => '東京都新宿区',
            'building' => 'テストビル101',
        ]);

        $user2 = User::create([
            'name' => 'Test User2',
            'email' => 'test2@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        Profile::create([
            'user_id' => $user2->id,
            'postcode' => '123-4567',
            'address' => '大阪府大阪市中央区',
            'building' => 'テストビル202',
        ]);

        $user3 = User::create([
            'name' => 'Test User3',
            'email' => 'test3@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        Profile::create([
            'user_id' => $user3->id,
            'postcode' => '123-4567',
            'address' => '福岡県福岡市博多区',
            'building' => 'テストビル303',
        ]);
    }
}
