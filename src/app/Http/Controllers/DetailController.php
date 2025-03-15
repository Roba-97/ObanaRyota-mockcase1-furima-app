<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;

class DetailController extends Controller
{
    public function index(Item $item)
    {
        $categories = $item->categories()->get();
        $condition = $item->condition()->first();
        $comments = $item->comments()->get();
        
        return view('detail', compact('item', 'categories', 'condition', 'comments'));
    }

    public function comment(Item $item)
    {
        return view('detail', ['item' => $item]);
    }
}
