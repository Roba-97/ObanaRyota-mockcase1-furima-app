<?php

namespace Tests\Feature;

use Database\Seeders\ConditionsTableSeeder;
use Database\Seeders\CategoriesTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Models\User;
use App\Models\Item;
use Tests\TestCase;

// テストケースID:15
class ExhibitUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_exhibit_registeration_seccess()
    {
        $this->seed(ConditionsTableSeeder::class);
        $this->seed(CategoriesTableSeeder::class);

        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user)->post(
            '/sell',
            [
                'image' => 'コメント',
                'categories[]' => [1, 5],
                'condition_id' => 1,
                'name' => 'サンプル商品',
                'brand' => 'サンプルブランド',
                'detail' => 'サンプルテキスト',
                'price' => 1000
            ]
        );
    }
}
