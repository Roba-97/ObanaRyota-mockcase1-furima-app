<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;

class ItemController extends Controller
{
    private $column  = ['id','image_path','name','sold_flag'];

    public function index(Request $request)
    {
        $column = $this->column;

        session()->put('showMylist', false);
        
        if($request->page === "mylist" && Auth::check()) {
            session()->put('showMylist', true);
            $itemsId = Auth::user()->favorites()->select('Item_id')->get();
            $items = Item::whereIn('id', $itemsId)->where('seller_id', '<>', Auth::user()->id)->select($column)->get();
        }
        elseif(Auth::check()) {
            $items = Item::where('seller_id', '<>', Auth::user()->id)->select($column)->get();
        }
        elseif($request->page === "mylist") {
            session()->put('showMylist', true);
            $items = [];
        }
        else {
            $items = Item::select($column)->get();
        }

        return view('index', ['items' => $items, 'showMylist' => session()->get('showMylist')]);
    }

    public function search(Request $request)
    {
        $column = $this->column;
        $showMylist = session()->get('showMylist');

        if($showMylist && Auth::check()) {
            $itemsId = Auth::user()->favorites()->select('Item_id')->get();
            $items = Item::KeywordSearch($request->keyword)->whereIn('id', $itemsId)->where('seller_id', '<>', Auth::user()->id)->select($column)->get();
        }
        else if(Auth::check()) {
            $items = Item::KeywordSearch($request->keyword)->where('seller_id', '<>', Auth::user()->id)->select($column)->get();
        }
        elseif($showMylist) {
            $items = [];
        }
        else {
            $items = Item::KeywordSearch($request->keyword)->select($column)->get();
        }

        return view('index', ['items' => $items, 'showMylist' => $showMylist]);
    }
}
