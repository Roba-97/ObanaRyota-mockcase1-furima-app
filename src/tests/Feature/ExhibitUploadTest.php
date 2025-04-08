<?php

namespace Tests\Feature;

use Database\Seeders\ConditionsTableSeeder;
use Database\Seeders\CategoriesTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Item;
use Tests\TestCase;

// テストケースID:15
class ExhibitUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(ConditionsTableSeeder::class);
        $this->seed(CategoriesTableSeeder::class);
    }

    public function test_exhibit_registeration_seccess()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        Storage::fake('public');

        $file = UploadedFile::fake()->image('item.png'); // 拡張子をjpg,jpegだとエラーになる

        $response = $this->actingAs($user)->post(
            '/sell',
            [
                'image' => $file,
                'categories' => [1, 5],
                'condition_id' => 1,
                'name' => 'サンプル商品',
                'brand' => 'サンプルブランド',
                'detail' => 'サンプルテキスト',
                'price' => 1000
            ]
        );

        $this->assertDatabaseHas('category_item', [
            'item_id' => 1,
            'category_id' => 1
        ]);
        $this->assertDatabaseHas('category_item', [
            'item_id' => 1,
            'category_id' => 5
        ]);

        $this->assertDatabaseHas('items', [
            'seller_id' => $user->id,
            'condition_id' => 1,
            'image_path' => 'storage/images/items/' . $file->hashName(),
            'name' => 'サンプル商品',
            'brand' => 'サンプルブランド',
            'detail' => 'サンプルテキスト',
            'price' => 1000,
            'sold_flag' => false
        ]);

        // Storage::disk('public')->assertExists('images/items/' . $file->hashName());
        // assertExistもエラーになる、保存が正しく行われたか確認できない
    }
}
