<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\DuskTestHelpers\BrowserUtils;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Condition;
use App\Models\Item;
use App\Models\User;

// テストケースID:7
class ItemDetailTest extends DuskTestCase
{
    use BrowserUtils;

    private $item;
    private $commentUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');

        $this->item = Item::where('name', '腕時計')->first();
        $this->item->update(['brand' => 'test']);

        $categoryIds = Category::whereIn('content', ['ファッション', 'メンズ', 'アクセサリー'])->pluck('id')->toArray();
        $this->item->categories()->sync($categoryIds);

        $this->commentUser = User::factory()->create();
        Comment::create([
            'item_id' => $this->item->id,
            'user_id' => $this->commentUser->id,
            'content' => 'テストコメント'
        ]);
    }

    public function test_get_item_detail_infomation()
    {
        $item = $this->item;
        $commentUser = $this->commentUser;
        $condition = Condition::find($item->condition_id)->content;
        $categories = ['ファッション', 'メンズ', 'アクセサリー'];

        $this->browse(function (Browser $browser) use ($item, $condition, $categories, $commentUser) {
            $browser->visit("/item/{$item->id}")
                ->assertSee($item->name)
                ->assertSee($item->brand)
                ->assertSee(number_format($item->price))
                ->assertSee($item->detail)
                ->assertSee($item->favorites()->count())
                ->assertSee($item->comments()->count())
                ->assertSee($condition)
                ->assertSee($commentUser->name)
                ->assertSee('テストコメント');
            foreach ($categories as $category) {
                $browser->assertSee($category);
            }
            $this->screenshot_whole_page($browser, 'ItemDetailTest/item_detail_view');
        });
    }
}
