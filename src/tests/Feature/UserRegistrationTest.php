<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

// テストケースID1
class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_required_validate()
    {
        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertInvalid([
            'name' => 'お名前を入力してください',
        ]);
    }

    public function test_email_required_validate()
    {
        $response = $this->post('/register', [
            'name' => 'user',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertInvalid([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    public function test_password_required_validate()
    {
        $response = $this->post('/register', [
            'name' => 'user',
            'email' => 'test@example.com',
            'password_confirmation' => 'password'
        ]);

        $response->assertInvalid([
            'password' => 'パスワードを入力してください',
        ]);
    }

    public function test_password_min_validate()
    {
        $response = $this->post('/register', [
            'name' => 'user',
            'email' => 'test@example.com',
            'password' => 'shorter', // 7文字のパスワード
            'password_confirmation' => 'password'
        ]);

        $response->assertInvalid([
            'password' => 'パスワードは8文字以上で入力してください',
        ]);
    }

    public function test_password_confirmation_same_validate()
    {
        $response = $this->post('/register', [
            'name' => 'user',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'differenet'
        ]);

        $response->assertInvalid([
            'password_confirmation' => 'パスワードと一致しません',
        ]);
    }

    public function test_registration_success()
    {
        $response = $this->post('/register', [
            'name' => 'user',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertRedirect('/mypage/profile');
    }
}
