<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Item;
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

    public function toggleItemFavorite(Item $item)
    {
        if (Auth::user()->favorites()->where('item_id', $item->id)->exists()) {
            Favorite::where('item_id', $item->id)->where('user_id', Auth::user()->id)->delete();
        } else {
            $data = [
                'item_id' => $item->id,
                'user_id' => Auth::user()->id
            ];
            Favorite::create($data);
        }

        return redirect()->route('detail.index', ['item' => $item->id]);
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
