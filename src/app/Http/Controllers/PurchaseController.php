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
        $delivery_address = Auth::user()->profile()->select('postcode', 'address', 'building')->first();

        return view('purchase', compact('item', 'delivery_address'));
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

    public function edit(Item $item)
    {
        return view('address', ['item' => $item]);
    }

    public function update(Request $request, Item $item)
    {
        $delivery_address = (object) [
            'postcode' => $request->input('postcode'),
            'address' => $request->input('address'),
            'building' => $request->input('building')
        ];
        
        return view('purchase', compact('item', 'delivery_address')); 
    }
}
