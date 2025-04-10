<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = DB::table('items')->pluck('id', 'name')->toArray();
        $categories = DB::table('categories')->pluck('id', 'content')->toArray();

        $data = [
            '腕時計' => ['メンズ', 'アクセサリー'],
            'HDD' => ['家電'],
            '玉ねぎ3束' => ['キッチン', 'ハンドメイド'],
            '革靴' => ['メンズ', 'ファッション'],
            'ノートパソコン' => ['家電'],
            'マイク' => ['家電'],
            'ショルダーバッグ' => ['レディース', 'ファッション'],
            'タンブラー' => ['キッチン'],
            'コーヒーミル' => ['キッチン'],
            'メイクセット' => ['レディース'],
        ];

        foreach ($data as $itemName => $categoryNames) {
            $itemId = $items[$itemName] ?? null;
            if (!$itemId) continue;

            foreach ($categoryNames as $categoryName) {
                $categoryId = $categories[$categoryName] ?? null;
                if (!$categoryId) continue;

                DB::table('category_item')->insert([
                    'item_id' => $itemId,
                    'category_id' => $categoryId,
                ]);
            }
        }
    }
}
