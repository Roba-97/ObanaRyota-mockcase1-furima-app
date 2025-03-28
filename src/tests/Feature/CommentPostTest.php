<?php

namespace Tests\Feature;

use Database\Seeders\ConditionsTableSeeder;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Models\User;
use App\Models\Item;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

// テストケースID:9
class CommentPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_comment_success()
    {
        $this->seed(ConditionsTableSeeder::class);
        $seller = User::factory()->create();
        $item = Item::create([
            'seller_id' => $seller->id,
            'condition_id' => 1,
            'image_path' => 'path',
            'name' => 'test',
            'brand' => 'test',
            'price' => 100,
            'detail' => 'test',
            'sold_flag' => false
        ]);
        $countBefore = $item->comments()->count();

        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $this->actingAs($user)->post('/comment/1', ['content' => 'コメント']);

        $this->assertDatabaseHas('comments', [
            'item_id' => 1,
            'user_id' => $user->id,
            'content' => 'コメント'
        ]);

        assertEquals($item->comments()->count(), $countBefore + 1);
    }

    public function test_comment_unauthenticated_validate()
    {
        $response = $this->post('/comment/1', ['content' => 'コメント']);

        $response->assertRedirect('/login');
    }

    public function test_comment_required_validate()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/comment/1', ['content' => '']);

        $response->assertSessionHasErrors(['content']);
    }


    public function test_comment_max_validate()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/comment/1', [
                'content' => Str::random(256)
            ]);

        $response->assertSessionHasErrors([
            'content' => 'コメントは255文字以内で入力してください',
        ]);
    }
}
