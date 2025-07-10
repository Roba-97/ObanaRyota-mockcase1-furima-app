<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\ChatRoom;
use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    private $options  = ['', 'konbini', 'card'];

    public function index(Request $request, Item $item)
    {
        session()->forget('selectedValue');

        if ($item->sold_flag && $request->status === 'canceled') {
            $item->update(['sold_flag' => false]);

            Purchase::where('item_id', $item->id)->where('buyer_id', Auth::user()->id)->delete();
        }

        $delivery_address = Auth::user()->profile()->select('postcode', 'address', 'building')->first();

        return view('purchase', compact('item', 'delivery_address'));
    }

    public function stripe(PurchaseRequest $request, Item $item)
    {
        if ($item && !$item->sold_flag) {
            $item->update(['sold_flag' => true]);

            $purchase = Purchase::create([
                'item_id' => $item->id,
                'buyer_id' => Auth::user()->id,
                'payment' => $request->input('payment'),
                'delivery_postcode' => $request->input('delivery_postcode'),
                'delivery_address' => $request->input('delivery_address'),
            ]);
            ChatRoom::create([
                'purchase_id' => $purchase->id,
            ]);
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        $method = $this->options[$request->input('payment')];

        $session = Session::create([
            'payment_method_types' => [$method],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('mypage.index', ['page' => 'buy']),
            'cancel_url' => route('purchase.index', ['item' => $item, 'status' => 'canceled']),
        ]);

        return redirect($session->url);
    }

    public function edit(Item $item)
    {
        return view('address', ['item' => $item]);
    }

    public function update(AddressRequest $request, Item $item)
    {
        $delivery_address = (object) [
            'postcode' => $request->input('postcode'),
            'address' => $request->input('address'),
            'building' => $request->input('building')
        ];

        return view('purchase', compact('item', 'delivery_address'));
    }
}
