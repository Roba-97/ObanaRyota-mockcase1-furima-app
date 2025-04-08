<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\DuskTestHelpers\BrowserUtils;
use App\Models\Favorite;
use App\Models\Item;
use App\Models\User;

// テストケースID:8
class ItemFavoriteRegistrationTest extends DuskTestCase
{
    use BrowserUtils;

    private $user;
    private $item;
    private $anotherItem;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');

        $this->user = User::factory()->create();
        $this->item = Item::where('name', '腕時計')->first();
        $this->anotherItem = Item::where('name', 'HDD')->first();
    }

    public function test_register_favorite_item_view()
    {
        $user = $this->user;
        $item = $this->item;
        $countBefore = $item->favorites()->count();

        $this->browse(function (Browser $browser) use ($user, $item) {
            $browser->loginAs($user)
                ->visit("/item/{$item->id}");
            // アイコン押下前の色とカウントの確認
            $this->screenshot_whole_page($browser, 'ItemFavoriteRegistrationTest/register_favorite_item_before');
            $browser->click('a[href="/favorite/' . $item->id . '"]');
            // アイコン押下後の確認
            $this->screenshot_whole_page($browser, 'ItemFavoriteRegistrationTest/register_favorite_item_after');
        });

        $this->assertEquals($this->item->favorites()->count(), $countBefore + 1);
        $this->assertDatabaseHas('favorites', [
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_unregister_favorite_item_view()
    {
        $user = $this->user;
        $item = $this->anotherItem;

        Favorite::create([
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);

        $countBefore = $item->favorites()->count();

        $this->browse(function (Browser $browser) use ($user, $item) {
            $browser->loginAs($user)
                ->visit("/item/{$item->id}");
            // アイコン押下前の色とカウントの確認
            $this->screenshot_whole_page($browser, 'ItemFavoriteRegistrationTest/unregister_favorite_item_before');
            $browser->click('a[href="/favorite/' . $item->id . '"]');
            // アイコン押下後の確認
            $this->screenshot_whole_page($browser, 'ItemFavoriteRegistrationTest/unregister_favorite_item_after');
        });

        $this->assertEquals($this->item->favorites()->count(), $countBefore - 1);
        $this->assertDatabaseMissing('favorites', [
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);
    }
}
