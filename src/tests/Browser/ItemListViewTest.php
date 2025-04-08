<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\DuskTestHelpers\BrowserUtils;
use App\Models\Item;
use App\Models\User;

// テストケースID:4
class ItemListViewTest extends DuskTestCase
{
    use BrowserUtils;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');
    }

    public function test_all_items_view()
    {
        $itemNames = Item::all()->pluck('name')->toArray();
        $this->browse(function (Browser $browser) use ($itemNames) {
            $browser->visit('/');
            foreach ($itemNames as $itemName) {
                $browser->assertSee($itemName);
            }
            $this->screenshot_whole_page($browser, 'ItemListViewTest/all_items_view');
        });
    }

    public function test_sold_item_view()
    {
        Item::where('name', '腕時計')->first()->update(["sold_flag" => true]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('sold');
            $this->screenshot_whole_page($browser, 'ItemListViewTest/all_items_view_include_sold_item');
        });
    }

    public function test_all_items_view_other_than_exhibit()
    {
        $user = User::factory()->create();
        Item::where('name', '革靴')->first()->update(["seller_id" => $user->id]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/')
                ->assertDontSee('革靴');
            $this->screenshot_whole_page($browser, 'ItemListViewTest/all_items_view_other_than_exhibit');
        });
    }
}
