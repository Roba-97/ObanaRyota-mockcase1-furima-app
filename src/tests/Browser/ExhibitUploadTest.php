<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Item;

// テストケースID:15
class ExhibitUploadTest extends DuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:refresh');
        $this->artisan('db:seed', ['--class' => 'CategoriesTableSeeder']);
        $this->artisan('db:seed', ['--class' => 'ConditionsTableSeeder']);
    }

    public function test_upload_exhibit_success()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $filepath = public_path('images/dummies/Armani+Mens+Clock.jpg');;
            $browser->loginAs($user)
                ->visit('/sell')
                ->attach('image', $filepath)
                ->click("label[for=\"category1\"]")
                ->click("label[for=\"category5\"]")
                ->click("label[for=\"category8\"]")
                ->select('condition_id', 1)
                ->type('name', 'Item')
                ->type('brand', 'brand')
                ->type('detail', 'sampletext')
                ->type('price', 1000)
                ->press('出品する')
                ->assertPathIs('/mypage')
                ->screenshot('upload_exhibit_success');
        });

        $this->assertDatabaseHas('items', [
            'seller_id' => $user->id,
            'condition_id' => 1,
            'name' => 'Item',
            'brand' => 'brand',
            'detail' => 'sampletext',
            'price' => 1000
        ]);

        $item = Item::where('name', 'Item')->first();

        $this->assertDatabaseHas('category_item', ['item_id' => $item->id, 'category_id' => 1]);
        $this->assertDatabaseHas('category_item', ['item_id' => $item->id, 'category_id' => 5]);
        $this->assertDatabaseHas('category_item', ['item_id' => $item->id, 'category_id' => 8]);
    }
}
