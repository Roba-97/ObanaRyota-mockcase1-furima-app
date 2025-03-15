<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Item;
use App\Models\User;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $showSellItems = true;

        if($request->page === "buy") {
            $showSellItems = false;
            $itemsId = Auth::user()->purchases()->select('id')->get();
            $items = Item::whereIn('id', $itemsId)->select(['id','image_path','name'])->get();
        }
        else {
            $itemsId = Auth::user()->items()->select('id')->get();
            $items = Item::whereIn('id', $itemsId)->select(['id','image_path','name'])->get();
        }

        return view('mypage', ['items' => $items, 'showSellItems' => $showSellItems]);
    }

    public function edit()
    {
        return view('profile');
    }

    public function update()
    {
        return view('profile');
    }
}
