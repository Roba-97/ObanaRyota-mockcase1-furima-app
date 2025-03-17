<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Item;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function index(Item $item)
    {
        return view('purchase', ['item' => $item]);
    }

    public function store(Request $request, Item $item)
    {
        dd($request);
        return redirect('/mypage?page=buy'); 
    }

    public function edit()
    {
        return view('address');
    }

    public function update()
    {
        return redirect()->route('purchase.index', ['item' => $item->id]); 
    }
}
