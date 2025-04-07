<?php

namespace Tests\Browser;

use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use App\Models\Item;
use App\Models\User;
use Tests\DuskTestCase;

// テストケースID:9
class CommentPostTest extends DuskTestCase
{
    use DatabaseMigrations;

    private $user;
    private $item;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');

        $this->user = User::factory()->create();
        $this->item = Item::first();
    }

    public function test_post_comment_success()
    {
        $user = $this->user;
        $item = $this->item;

        $this->browse(function (Browser $browser) use ($user, $item) {
            $browser->loginAs($user)
                ->visit("/item/{$item->id}")
                ->type('content', 'コメント')
                ->press('コメントを送信する')
                ->assertSee('コメント');
        });
    }

    public function test_comment_unauthenticated_validate()
    {
        $item = $this->item;

        $this->browse(function (Browser $browser) use ($item) {
            $browser->driver->manage()->deleteAllCookies();
            $browser->visit("/item/{$item->id}")
                ->assertGuest()
                ->type('content', 'コメント')
                ->press('コメントを送信する')
                ->waitForText('ログイン')
                ->assertPathIs('/login');
        });
    }

    public function test_comment_required_validate()
    {
        $user = $this->user;
        $item = $this->item;

        $this->browse(function (Browser $browser) use ($user, $item) {
            $browser->loginAs($user)
                ->visit("/item/{$item->id}")
                ->type('content', '')
                ->press('コメントを送信する')
                ->assertSee('コメントを入力してください');
        });
    }

    public function test_comment_max_validate()
    {
        $user = $this->user;
        $item = $this->item;

        $this->browse(function (Browser $browser) use ($user, $item) {
            $browser->loginAs($user)
                ->visit("/item/{$item->id}")
                ->type('content', Str::random(256))
                ->press('コメントを送信する')
                ->assertSee('コメントは255文字以内で入力してください');
        });
    }
}
