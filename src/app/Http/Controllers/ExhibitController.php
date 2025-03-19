<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Http\Requests\ExhibitRequest;

class ExhibitController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('exhibit', compact('categories', 'conditions'));
    }

    public function store(Request $request)
    {
        $path = $request->file('image')->store('public/images/items');

        $item = Item::create([
            'seller_id' => Auth::user()->id,
            'condition_id' => $request->input('condition_id'),
            'image_path' => 'storage/images/items/' . basename($path),
            'name' => $request->input('name'),
            'brand' => $request->input('brand'),
            'price' => $request->input('price'),
            'detail' => $request->input('detail'),
            'sold_flag' => false,
        ]);
        $item->categories()->sync($request->categories);

        return redirect('/mypage?page=sell');
    }
}
