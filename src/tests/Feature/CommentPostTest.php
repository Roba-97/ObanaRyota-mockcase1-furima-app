<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Models\User;
use App\Models\Item;
use App\Models\Condition;
use Tests\TestCase;

// テストケースID:9
class CommentPostTest extends TestCase
{
    use RefreshDatabase;

    protected $seller;
    protected $user;
    protected $item;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seller = User::factory()->create();
        $this->user = User::factory()->create();

        $condition = Condition::create([
            'content' => '良好'
        ]);

        $this->item = Item::create([
            'seller_id' => $this->seller->id,
            'condition_id' => $condition->id,
            'image_path' => 'path',
            'name' => 'test',
            'brand' => 'test',
            'price' => 100,
            'detail' => 'test',
            'sold_flag' => false
        ]);
    }

    public function test_post_comment_success()
    {
        $countBefore = $this->item->comments()->count();

        $response = $this->actingAs($this->user)->post('/comment/1', ['content' => 'コメント']);

        $this->assertDatabaseHas('comments', [
            'item_id' => 1,
            'user_id' => $this->user->id,
            'content' => 'コメント'
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertEquals($this->item->comments()->count(), $countBefore + 1);
    }

    public function test_comment_unauthenticated_validate()
    {
        $response = $this->post('/comment/1', ['content' => 'コメント']);

        $response->assertRedirect('/login');
    }


    public function test_comment_required_validate()
    {
        $response = $this->actingAs($this->user)->post('/comment/1', ['content' => '']);

        dump(session()->all());
    }

    public function test_comment_max_validate()
    {
        $response = $this->actingAs($this->user)->post('/comment/1', ['content' => Str::random(256)]);

        $response->assertSessionHasErrorsIn('default', [
            'content' => 'コメントは255文字以内で入力してください'
        ]);
    }
}
