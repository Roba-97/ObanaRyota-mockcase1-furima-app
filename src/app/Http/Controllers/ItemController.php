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
        
        if($request->tab === "mylist" && Auth::check()) {
            $showMylist = true;
            $itemsId = Auth::user()->favorites()->select('Item_id')->get();
            $items = Item::whereIn('id', $itemsId)->select('id','image_path','name','sold_flag')->get();
        }
        elseif($request->tab === "mylist") {
            $showMylist = true;
            $items = [];
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
