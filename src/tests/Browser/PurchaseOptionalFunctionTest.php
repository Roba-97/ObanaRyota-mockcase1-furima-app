<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\DuskTestHelpers\BrowserUtils;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;

// テストケースID:11,12
class PurchaseOptionalFunctionTest extends DuskTestCase
{
    use BrowserUtils;

    private $user;
    private $item;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
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

    public function test_select_payment_method_immediately_view()
    {
        $user = $this->user;
        $item = $this->item;

        $this->browse(function (Browser $browser) use ($user, $item) {
            $browser->loginAs($user)
                ->visit("/purchase/{$item->id}")
                ->select('payment', 1)
                ->pause(1000)
                ->assertSee('コンビニ払い')
                ->select('payment', 2)
                ->pause(1000)
                ->assertSee('カード払い');
        });
    }

    public function test_delivery_address_correctly_changed()
    {
        $user = $this->user;
        $item = $this->item;

        $this->browse(function (Browser $browser) use ($user, $item) {
            $browser->loginAs($user)
                ->visit("/purchase/{$item->id}")
                ->select('payment', 2)
                ->pause(1000)
                ->clickLink('変更する')
                ->type('postcode', '333-3333')
                ->type('address', 'changedAddress')
                ->type('building', 'changedBuilding')
                ->press('更新する')
                ->pause(1000)
                ->assertSee('333-3333')
                ->assertSee('changedAddress' . 'changedBuilding') // 配送先住所変更の反映確認
                ->press('購入する');
            $this->type_stripe_card_payment_page($browser);
        });

        // 送付住所が正しく結びついていることの確認
        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'buyer_id' => $user->id,
            'payment' => 2,
            'delivery_postcode' => '333-3333',
            'delivery_address' => 'changedAddress' . 'changedBuilding',
        ]);
    }
}
