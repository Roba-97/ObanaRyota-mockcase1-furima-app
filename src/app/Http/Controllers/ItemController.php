<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $showMylist = false;
        
        if($request->page === "mylist" && Auth::check()) {
            $showMylist = true;
            $itemsId = Auth::user()->favorites()->select('Item_id')->get();
            $items = Item::whereIn('id', $itemsId)->where('seller_id', '<>', Auth::user()->id)->select('id','image_path','name','sold_flag')->get();
        }
        elseif($request->page === "mylist") {
            $showMylist = true;
            $items = [];
        }
        elseif(Auth::check()) {
            $items = Item::where('seller_id', '<>', Auth::user()->id)->select('id','image_path','name','sold_flag')->get();
        }
        else {
            $items = Item::select('id','image_path','name','sold_flag')->get();
        }

        return view('index', ['items' => $items, 'showMylist' => $showMylist]);
    }

    public function detail(Item $item)
    {
        return view('detail', ['item' => $item]);
    }
}
