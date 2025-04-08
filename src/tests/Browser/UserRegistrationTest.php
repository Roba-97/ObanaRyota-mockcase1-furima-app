<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

// テストケースID:1
class UserRegistrationTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_name_required_validate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('email', 'test@example.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->press('登録する')
                ->assertSee('お名前を入力してください');
        });
    }

    public function test_email_required_validate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'user')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->press('登録する')
                ->assertSee('メールアドレスを入力してください');
        });
    }

    public function test__password_required_validate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'user')
                ->type('email', 'test@example.com')
                ->type('password_confirmation', 'password')
                ->press('登録する')
                ->assertSee('パスワードを入力してください');
        });
    }

    public function test__password_min_validate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'user')
                ->type('email', 'test@example.com')
                ->type('password', 'shorter')
                ->type('password_confirmation', 'shorter')
                ->press('登録する')
                ->assertSee('パスワードは8文字以上で入力してください');
        });
    }

    public function test_password_confirmation_same_validate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'user')
                ->type('email', 'test@example.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'different')
                ->press('登録する')
                ->assertSee('パスワードと一致しません');
        });
    }

    public function test_registration_success()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'user')
                ->type('email', 'test@example.com')
                ->type('password', 'password')
                ->type('password_confirmation', 'password')
                ->press('登録する')
                ->assertPathIs('/email/verify');
        });
    }
}
