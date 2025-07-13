<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $param = null;

        switch ($request->page) {
            case 'deal':
                $param = 'deal';
                $items = Auth::user()->dealingItems();
                break;

            case 'buy':
                $param = 'buy';
                $itemsId = Auth::user()->purchases()->select('item_id')->get();
                $items = Item::whereIn('id', $itemsId)->select(['id', 'image_path', 'name', 'sold_flag'])->get();
                break;

            default:
                $itemsId = Auth::user()->items()->select('id')->get();
                $items = Item::whereIn('id', $itemsId)->select(['id', 'image_path', 'name', 'sold_flag'])->get();
                break;
        }

        $count = Auth::user()->dealingItems()->sum(function ($item) {
            return $item->chatRoom->getNotificationCount(Auth::user());
        });

        return view('mypage', ['items' => $items, 'param' => $param, 'notificationCount' => $count]);
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
        $user = Auth::user();
        $profile = $user->profile()->first();

        if (null !== $request->file('image')) {

            if ($profile && $profile->image_path) {
                $existingPath = str_replace('storage/', 'public/', $profile->image_path);
                Storage::delete($existingPath);
            }

            $path = $request->file('image')->store('public/images/users');
            $path = 'storage/images/users/' . basename($path);
        } else {
            $path = $profile ? $profile->image_path : null;
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
