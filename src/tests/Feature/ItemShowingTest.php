<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Models\User;
use App\Models\Item;
use Tests\TestCase;

// テストケースID:4
class ItemShowingTest extends TestCase
{
    use RefreshDatabase;

    protected $item;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->assertDatabaseCount('conditions', 1);

        $this->item = Item::select(['id', 'image_path', 'name', 'sold_flag'])->get();
    }

    public function test_getting_all_items()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('items');

        $data = $response->getOriginalContent()->getData();
        $this->assertEquals(10, count($data['items']));
    }
    /*
    public function test_showing_sold_items()
    {
        $id = $this->item->first()->id;
        $this->item->where('id', $id)->update(['sold_flag' => true]);
        $view = $this->view('index', ['items' => $this->item, 'showMylist' => false]);

        $view->assertSeeText('Sold');
    }
    */
}
