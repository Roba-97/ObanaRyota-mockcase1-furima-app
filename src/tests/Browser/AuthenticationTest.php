<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

// テストケースID:2,3
class AuthenticationTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_email_required_validate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('password', 'password')
                ->press('ログインする')
                ->assertSee('メールアドレスを入力してください');
        });
    }

    public function test_password_required_validate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'test@example.com')
                ->press('ログインする')
                ->assertSee('パスワードを入力してください');
        });
    }

    public function test_unregistered_validate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'test@example.com')
                ->type('password', 'password')
                ->press('ログインする')
                ->assertSee('ログイン情報が登録されていません');
        });
    }

    public function test_login_success()
    {
        User::factory()->create([
            'name' => 'user',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'test@example.com')
                ->type('password', 'password')
                ->press('ログインする')
                ->assertAuthenticated();
        });
    }

    public function test_logout_success()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/')
                ->press('ログアウト')
                ->assertGuest()
                ->assertPathIs('/login');
        });
    }
}
