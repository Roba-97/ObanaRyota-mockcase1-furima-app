<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\DuskTestHelpers\BrowserUtils;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;
use App\Models\Purchase;

// テストケースID:13,14
class UserProfileTest extends DuskTestCase
{
    use BrowserUtils;

    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
        $this->artisan('db:seed', ['--class' => 'TestDatabaseSeeder']);

        $this->user = User::factory()->create();

        Profile::create([
            'image_path' => 'images/dummies/User+Icon.jpeg',
            'user_id' => $this->user->id,
            'postcode' => '000-0000',
            'address' => 'sampleAddress',
            'building' => 'sampleBuilding',
        ]);

        $id = Item::where('name', 'HDD')->value('id');
        Purchase::create([
            'item_id' => $id,
            'buyer_id' => $this->user->id,
            'payment' => 1,
            'delivery_postcode' => $this->user->profile()->first()->postcode,
            'delivery_address' => $this->user->profile()->first()->address . $this->user->profile()->first()->building,
        ]);
    }

    public function test_get_mypage_user_information()
    {
        $user = $this->user;
        Item::where('name', '腕時計')->first()->update(['seller_id' => $user->id]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/mypage')
                ->clickLink('購入した商品')
                ->assertSee('HDD')
                ->screenshot('UserProfileTest/mypage_user_information_with_purchase')
                ->clickLink('出品した商品')
                ->pause(500)
                ->assertSee('腕時計')
                ->screenshot('UserProfileTest/mypage_user_information_with_exhibit');
        });
    }

    public function test_get_profile_user_information()
    {
        $user = $this->user;

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/mypage/profile')
                ->assertInputValue('name', $user->name)
                ->assertInputValue('postcode', $user->profile()->first()->postcode)
                ->assertInputValue('address', $user->profile()->first()->address)
                ->assertInputValue('building', $user->profile()->first()->building);
            $this->screenshot_whole_page($browser, 'UserProfileTest/profile_user_information');
        });
    }
}
