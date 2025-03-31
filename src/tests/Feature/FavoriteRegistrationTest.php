<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Models\User;
use App\Models\Item;
use App\Models\Condition;
use App\Models\Favorite;
use Tests\TestCase;

// テストケースID:8
class FavoriteRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected $seller;
    protected $user;
    protected $item;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seller = User::factory()->create();
        $this->user = User::factory()->create();

        $condition = Condition::create([
            'content' => '良好'
        ]);

        $this->item = Item::create([
            'seller_id' => $this->seller->id,
            'condition_id' => $condition->id,
            'image_path' => 'path',
            'name' => 'test',
            'brand' => 'test',
            'price' => 100,
            'detail' => 'test',
            'sold_flag' => false
        ]);
    }

    public function test_favorite_register()
    {
        $countBefore = $this->item->favorites()->count();

        $this->actingAs($this->user)->get('/favorite/' . $this->item->id);

        $this->assertDatabaseHas('favorites', [
            'item_id' => $this->item->id,
            'user_id' => $this->user->id,
        ]);

        $this->assertEquals($this->item->favorites()->count(), $countBefore + 1);
    }

    public function test_icon_color_change()
    {
        $this->actingAs($this->user)->get('/favorite/' . $this->item->id);
    }

    public function test_favorite_unregister()
    {
        Favorite::create([
            'item_id' => $this->item->id,
            'user_id' => $this->user->id,
        ]);

        $countBefore = $this->item->favorites()->count();

        $this->actingAs($this->user)->get('/favorite/' . $this->item->id);

        $this->assertDatabaseMissing('favorites', [
            'item_id' => $this->item->id,
            'user_id' => $this->user->id,
        ]);

        $this->assertEquals($this->item->favorites()->count(), $countBefore - 1);
    }
}
