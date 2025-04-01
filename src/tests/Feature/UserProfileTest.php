<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Profile;
use Tests\TestCase;

// テストケースID:13,14
class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        Storage::fake('public');
        $file = UploadedFile::fake()->image('userIcon.png');

        Profile::create([
            'user_id' => $this->user->id,
            'image_path' => 'storage/images/users/' . $file->hashName(),
            'postcode' => '000-0000',
            'address' => 'sampleAddress',
            'building' => 'sampleBuilding',
        ]);
    }

    public function test_get_mypage_user_information()
    {
        $response = $this->actingAs($this->user)->get('/mypage');

        $response->assertStatus(200);
    }

    public function test_get_user_profile()
    {
        $response = $this->actingAs($this->user)->get('/mypage/profile');

        $response->assertSee($this->user->name);
        $response->assertSee($this->user->profile()->first()->postcode);
        $response->assertSee($this->user->profile()->first()->address);
        $response->assertSee($this->user->profile()->first()->building);
    }
}
