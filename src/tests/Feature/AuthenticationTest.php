<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Tests\TestCase;

// テストケースID:2,3
class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_required_validate()
    {
        $response = $this->post('/login', [
            'password' => 'password',
        ]);

        $response->assertInvalid([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    public function test_password_required_validate()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
        ]);

        $response->assertInvalid([
            'password' => 'パスワードを入力してください',
        ]);
    }

    public function test_unregistered_validate()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $response->assertInvalid([
            'email' => 'ログイン情報が登録されていません',
        ]);
    }

    public function test_login_success()
    {
        $user = User::factory()->create([
            'name' => 'user',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/?page=mylist');

        $this->assertAuthenticatedAs($user);
    }

    public function test_logout_success()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
