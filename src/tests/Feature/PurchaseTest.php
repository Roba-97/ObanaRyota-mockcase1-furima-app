<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Models\User;
use App\Models\Item;
use App\Models\Condition;
use App\Models\Profile;
use Tests\TestCase;

// テストケースID:10
class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $item;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $seller = User::factory()->create();

        $condition = Condition::create([
            'content' => '良好'
        ]);

        $this->item = Item::create([
            'seller_id' => $seller->id,
            'condition_id' => $condition->id,
            'image_path' => 'path',
            'name' => 'test',
            'brand' => 'test',
            'price' => 100,
            'detail' => 'test',
            'sold_flag' => false
        ]);

        Profile::create([
            'user_id' => $this->user->id,
            'image_path' => 'samplePath',
            'postcode' => '000-0000',
            'address' => 'sampleAddress',
            'building' => 'sampleBuilding',
        ]);
    }

    public function test_purchase_item()
    {
        $response = $this->actingAs($this->user)
            ->post('/purchase/' . $this->item->id);

        $response->assertSuccessful();

        $this->assertDatabaseHas('purchases', [
            'item_id' => $this->item->id,
            'buyer_id' => $this->user->id,
            'payment' => 1,
            'delivery_postcode' => $this->user->profile()->first()->postcode,
            'delivery_address' =>  $this->user->profile()->first()->address . $this->user->profile()->first()->building,
        ]);
    }
}
