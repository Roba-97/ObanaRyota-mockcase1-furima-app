<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['seller_id' => random_int(1, 10),
            'condition_id' => 1,
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'name' => '腕時計',
            'price' => 15000,
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'sold_flag' => false
            ],
            ['seller_id' => random_int(1, 10),
            'condition_id' => 2,
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'name' => 'HDD',
            'price' => 5000,
            'detail' => '高速で信頼性の高いハードディスク',
            'sold_flag' => false
            ],
            ['seller_id' => random_int(1, 10),
            'condition_id' => 3,
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'name' => '玉ねぎ3束',
            'price' => 300,
            'detail' => '新鮮な玉ねぎ3束のセット',
            'sold_flag' => false
            ],
            ['seller_id' => random_int(1, 10),
            'condition_id' => 4,
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'name' => '革靴',
            'price' => 4000,
            'detail' => 'クラシックなデザインの革靴',
            'sold_flag' => false
            ],
            ['seller_id' => random_int(1, 10),
            'condition_id' => 1,
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'name' => 'ノートパソコン',
            'price' => 45000,
            'detail' => '高性能なノートパソコン',
            'sold_flag' => false
            ],
            ['seller_id' => random_int(1, 10),
            'condition_id' => 2,
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'name' => 'マイク',
            'price' => 8000,
            'detail' => '高音質のレコーディング用マイク',
            'sold_flag' => false
            ],
            ['seller_id' => random_int(1, 10),
            'condition_id' => 3,
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'detail' => 'おしゃれなショルダーバッグ',
            'sold_flag' => false
            ],
            ['seller_id' => random_int(1, 10),
            'condition_id' => 4,
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'name' => 'タンブラー',
            'price' => 500,
            'detail' => '使いやすいタンブラー',
            'sold_flag' => false
            ],
            ['seller_id' => random_int(1, 10),
            'condition_id' => 1,
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'name' => 'コーヒーミル',
            'price' => 4000,
            'detail' => '手動のコーヒーミル',
            'sold_flag' => false
            ],
            ['seller_id' => random_int(1, 10),
            'condition_id' => 2,
            'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/外出メイクアップセット.jpg',
            'name' => 'メイクセット',
            'price' => 2500,
            'detail' => '便利なメイクアップセット',
            'sold_flag' => false
            ],
        ];
        DB::table('items')->insert($items);
    }
}
