<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Favorite;
use App\Models\Item;
use App\Models\User;

// テストケースID:6
class ItemSearchTest extends DuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
        $this->artisan('db:seed', ['--class' => 'TestDatabaseSeeder']);
    }

    public function test_search_item()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('keyword', '腕')
                ->press('検索')
                ->assertSee('腕時計')
                ->screenshot('ItemSeaerchTest/search_item');
        });
    }

    public function test_keep_search_keyword()
    {
        $user = User::factory()->create();

        $ids = Item::where('price', '>=', 5000)->pluck('id');
        foreach ($ids as $id) {
            Favorite::create(['user_id' => $user->id, 'item_id' => $id]);
        }

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/')
                ->type('keyword', '腕')
                ->press('検索')
                ->assertSee('腕時計')
                ->screenshot('ItemSeaerchTest/keep_search_keyword_before')
                ->clickLink('マイリスト')
                ->assertSee('腕時計')
                ->screenshot('ItemSeaerchTest/keep_search_keyword_after');
        });
    }
}
