<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Favorite;
use App\Models\Item;
use App\Models\User;

// テストケースID:5
class MylistItemViewTest extends DuskTestCase
{
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');

        $this->user = User::factory()->create();

        $ids = Item::where('price', '>=', 5000)->pluck('id');
        foreach ($ids as $id) {
            Favorite::create(['user_id' => $this->user->id, 'item_id' => $id]);
        }
    }

    public function test_mylist_items_view()
    {
        $user = $this->user;
        $itemNames = Item::where('price', '>=', 5000)->pluck('name')->toArray();

        $this->browse(function (Browser $browser) use ($user, $itemNames) {
            $browser->loginAs($user)
                ->visit('/?page=mylist')
                ->screenshot('MylistItemViewTest/mylist_items_view');
            foreach ($itemNames as $itemName) {
                $browser->assertSee($itemName);
            }
        });
    }

    public function test_mylist_sold_item_view()
    {
        Item::where('name', '腕時計')->update(["sold_flag" => true]);
        $user = $this->user;

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/?page=mylist')
                ->assertSee('sold')
                ->screenshot('MylistItemViewTest/mylist_sold_item_view');
        });
    }

    public function test_mylist_view_other_than_exhibit()
    {
        $user = $this->user;
        Item::where('name', 'HDD')->first()->update(["seller_id" => $user->id]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/?page=mylist')
                ->assertDontSee('HDD')
                ->screenshot('MylistItemViewTest/mylist_view_other_than_exhibit');
        });
    }

    public function test_unauthorized_user_mylist_view()
    {
        $this->browse(function (Browser $browser) {
            $browser->driver->manage()->deleteAllCookies();
            $browser->visit('/?page=mylist')
                ->assertGuest()
                ->screenshot('MylistItemViewTest/unauthorized_user_mylist_view');
        });
    }
}
