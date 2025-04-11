<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $showMylist = $request->page === "mylist" ? true : false;
        $keyword = $request->keyword;

        $items = $this->search($showMylist, $keyword);

        return view('index', ['items' => $items, 'showMylist' => $showMylist, 'keyword' => $keyword]);
    }

    public function search($showMylist, $keyword)
    {
        $column = ['id', 'image_path', 'name', 'sold_flag'];

        if ($showMylist && Auth::check()) {
            $itemsId = Auth::user()->favorites()->select('Item_id')->get();
            $items = Item::KeywordSearch($keyword)->whereIn('id', $itemsId)->where('seller_id', '<>', Auth::user()->id)->select($column)->get();
        } elseif (Auth::check()) {
            $items = Item::KeywordSearch($keyword)->where('seller_id', '<>', Auth::user()->id)->select($column)->get();
        } elseif ($showMylist) {
            $items = [];
        } else {
            $items = Item::KeywordSearch($keyword)->select($column)->get();
        }

        return $items;
    }
}
