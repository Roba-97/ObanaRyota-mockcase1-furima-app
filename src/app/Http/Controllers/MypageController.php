<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Item;
use App\Models\User;
use App\Models\Profile;
use App\Http\Requests\AddressRequest;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $showSellItems = true;

        if ($request->page === "buy") {
            $showSellItems = false;
            $itemsId = Auth::user()->purchases()->select('item_id')->get();
            $items = Item::whereIn('id', $itemsId)->select(['id', 'image_path', 'name'])->get();
        } else {
            $itemsId = Auth::user()->items()->select('id')->get();
            $items = Item::whereIn('id', $itemsId)->select(['id', 'image_path', 'name'])->get();
        }


        return view('mypage', ['items' => $items, 'showSellItems' => $showSellItems]);
    }

    public function edit()
    {
        if (Auth::user()->profile()->exists()) {
            $profile = [
                'name' => Auth::user()->name,
                'postcode' => Auth::user()->profile()->first()->postcode,
                'address' => Auth::user()->profile()->first()->address,
                'building' => Auth::user()->profile()->first()->building,
            ];
        } else {
            $profile = [
                'name' => Auth::user()->name
            ];
        }

        session()->put('_old_input', $profile);

        return view('profile');
    }

    public function update(AddressRequest $request)
    {
        User::find(Auth::user()->id)->update(['name' => $request->name]);
        Profile::where('user_id', Auth::user()->id)
            ->update($request->except('name'));

        return view('profile');
    }
}
