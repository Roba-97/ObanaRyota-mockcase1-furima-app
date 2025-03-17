<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    public function index(Item $item)
    {
        return view('purchase', ['item' => $item]);
    }

    public function store(PurchaseRequest $request, Item $item)
    {
        $item->update(['sold_flag' => true]);

        Purchase::create([
            'item_id' => $item->id,
            'buyer_id' => Auth::user()->id,
            'payment' => $request->input('payment'),
            'delivery_address' => $request->input('delivery_address'),
        ]);

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
