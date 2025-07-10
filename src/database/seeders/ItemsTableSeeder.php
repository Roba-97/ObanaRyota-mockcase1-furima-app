<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userId1 = User::where('name', 'Test User1')->first()->id;
        $userId2 = User::where('name', 'Test User2')->first()->id;

        $items = [
            [
                'seller_id' => $userId1,
                'condition_id' => 1,
                'image_path' => 'images/dummies/Armani+Mens+Clock.jpg',
                'name' => '腕時計',
                'brand' => 'Chrono Clock',
                'price' => 15000,
                'detail' => 'スタイリッシュなデザインのメンズ腕時計',
                'sold_flag' => false
            ],
            [
                'seller_id' => $userId1,
                'condition_id' => 2,
                'image_path' => 'images/dummies/HDD+Hard+Disk.jpg',
                'name' => 'HDD',
                'brand' => 'DataDrive',
                'price' => 5000,
                'detail' => '高速で信頼性の高いハードディスク',
                'sold_flag' => false
            ],
            [
                'seller_id' => $userId1,
                'condition_id' => 3,
                'image_path' => 'images/dummies/iLoveIMG+d.jpg',
                'name' => '玉ねぎ3束',
                'brand' => null,
                'price' => 300,
                'detail' => '新鮮な玉ねぎ3束のセット',
                'sold_flag' => false
            ],
            [
                'seller_id' => $userId1,
                'condition_id' => 4,
                'image_path' => 'images/dummies/Leather+Shoes+Product+Photo.jpg',
                'name' => '革靴',
                'brand' => '匠Leather',
                'price' => 4000,
                'detail' => 'クラシックなデザインの革靴',
                'sold_flag' => false
            ],
            [
                'seller_id' => $userId1,
                'condition_id' => 1,
                'image_path' => 'images/dummies/Living+Room+Laptop.jpg',
                'name' => 'ノートパソコン',
                'brand' => 'パソ研工房',
                'price' => 45000,
                'detail' => '高性能なノートパソコン',
                'sold_flag' => false
            ],
            [
                'seller_id' => $userId2,
                'condition_id' => 2,
                'image_path' => 'images/dummies/Music+Mic+4632231.jpg',
                'name' => 'マイク',
                'brand' => 'SoundEcho',
                'price' => 8000,
                'detail' => '高音質のレコーディング用マイク',
                'sold_flag' => false
            ],
            [
                'seller_id' => $userId2,
                'condition_id' => 3,
                'image_path' => 'images/dummies/Purse+fashion+pocket.jpg',
                'name' => 'ショルダーバッグ',
                'brand' => 'Unique Bag Works',
                'price' => 3500,
                'detail' => 'おしゃれなショルダーバッグ',
                'sold_flag' => false
            ],
            [
                'seller_id' => $userId2,
                'condition_id' => 4,
                'image_path' => 'images/dummies/Tumbler+souvenir.jpg',
                'name' => 'タンブラー',
                'brand' => null,
                'price' => 500,
                'detail' => '使いやすいタンブラー',
                'sold_flag' => false
            ],
            [
                'seller_id' => $userId2,
                'condition_id' => 1,
                'image_path' => 'images/dummies/Waitress+with+Coffee+Grinder.jpg',
                'name' => 'コーヒーミル',
                'brand' => '豆挽きCafe',
                'price' => 4000,
                'detail' => '手動のコーヒーミル',
                'sold_flag' => false
            ],
            [
                'seller_id' => $userId2,
                'condition_id' => 2,
                'image_path' => 'images/dummies/外出メイクアップセット.jpg',
                'name' => 'メイクセット',
                'brand' => null,
                'price' => 2500,
                'detail' => '便利なメイクアップセット',
                'sold_flag' => false
            ],
        ];
        DB::table('items')->insert($items);
    }
}
