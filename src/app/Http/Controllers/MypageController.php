<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $showSellItems = true;

        if ($request->page === "buy") {
            $showSellItems = false;
            $itemsId = Auth::user()->purchases()->select('item_id')->get();
            $items = Item::whereIn('id', $itemsId)->select(['id', 'image_path', 'name', 'sold_flag'])->get();
        } else {
            $itemsId = Auth::user()->items()->select('id')->get();
            $items = Item::whereIn('id', $itemsId)->select(['id', 'image_path', 'name', 'sold_flag'])->get();
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
                'name' => Auth::user()->name,
                'postcode' => '',
                'address' => '',
                'building' => '',
            ];
        }

        return view('profile', compact('profile'));
    }

    public function update(ProfileRequest $request)
    {
        if (null !== $request->file('image')) {
            $path = $request->file('image')->store('public/images/users');
            $path = 'storage/images/users/' . basename($path);
        } elseif (null !== Profile::where('user_id', Auth::user()->id)->first()->image_path) {
            $path = Profile::where('user_id', Auth::user()->id)->first()->image_path;
        } else {
            $path = null;
        }

        // 初回ログインユーザへの処理
        if (!Auth::user()->profile()->exists()) {
            User::find(Auth::user()->id)->update(['name' => $request->name]);
            Profile::create([
                'user_id' => Auth::user()->id,
                'image_path' => $path,
                'postcode' => $request->postcode,
                'address' => $request->address,
                'building' => $request->building,
            ]);
            return redirect('/');
        }

        User::find(Auth::user()->id)->update(['name' => $request->name]);
        Profile::where('user_id', Auth::user()->id)
            ->update([
                'image_path' => $path,
                'postcode' => $request->postcode,
                'address' => $request->address,
                'building' => $request->building,
            ]);

        return redirect('/mypage');
    }
}
