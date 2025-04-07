<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;
use Tests\DuskTestCase;
use Tests\DuskTestHelpers\BrowserUtils;

// テストケースID:10
class PurchaseTest extends DuskTestCase
{
    use BrowserUtils;

    private $user;
    private $item;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');

        $this->user = User::factory()->create();

        Profile::create([
            'image_path' => 'images/dummies/User+Icon.jpeg',
            'user_id' => $this->user->id,
            'postcode' => '000-0000',
            'address' => 'sampleAddress',
            'building' => 'sampleBuilding',
        ]);

        $this->item = Item::where('name', '腕時計')->first();
    }

    public function test_purchase_success()
    {
        $user = $this->user;
        $item = $this->item;

        $this->browse(function (Browser $browser) use ($user, $item) {
            $browser->loginAs($user)
                ->visit("/purchase/{$item->id}")
                ->select('payment', 2)
                ->pause(1000)
                ->press('購入する')
                ->pause(5000)
                ->screenshot('purchase_success');
        });
    }

    public function test_purchase_store_success()
    {
        $user = $this->user;
        $item = $this->item;

        $this->browse(function (Browser $browser) use ($user, $item) {
            $browser->loginAs($user)
                ->visit("/purchase/{$item->id}")
                ->select('payment', 2)
                ->pause(1000)
                ->press('購入する');
            $this->type_stripe_card_payment_page($browser)
                ->assertSee('腕時計')
                ->screenshot('purchase_store_success') // 購入した商品一覧への追加
                ->visit('/')
                ->assertSee('sold')
                ->screenshot('purchase_sold_view_success'); // 商品一覧でのsold表示
        });

        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'buyer_id' => $user->id,
            'payment' => 2,
            'delivery_postcode' => $this->user->profile()->first()->postcode,
            'delivery_address' => $this->user->profile()->first()->address . $this->user->profile()->first()->building,
        ]);
    }
}
