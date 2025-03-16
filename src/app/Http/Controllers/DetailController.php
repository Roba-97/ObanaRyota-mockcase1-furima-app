<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use App\Http\Requests\CommentRequest;

class DetailController extends Controller
{
    public function index(Item $item)
    {
        $categories = $item->categories()->get();
        $condition = $item->condition()->first();
        $comments = $item->comments()->get();
        
        return view('detail', compact('item', 'categories', 'condition', 'comments'));
    }

    public function comment(CommentRequest $request, Item $item)
    {
        $data = [
            'item_id' => $item->id,
            'user_id' => Auth::user()->id,
            'content' => $request->content,
        ];

        Comment::create($data);

        return redirect()->route('detail.index', ['item' => $item->id])->withFragment('comment-form');
    }
}
