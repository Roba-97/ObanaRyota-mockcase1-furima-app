<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    private $method  = ['', 'konbini', 'card'];

    public function index(Item $item)
    {
        session()->forget('selectedValue');
        $delivery_address = Auth::user()->profile()->select('postcode', 'address', 'building')->first();

        return view('purchase', compact('item', 'delivery_address'));
    }

    public function stripe(PurchaseRequest $request, Item $item)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $method = $this->method[$request->input('payment')];

        $session = Session::create([
            'payment_method_types' => [$method],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' =>  $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchase.store') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('purchase.index', ['item' => $item->id]),
            'metadata' => [
                'item_id' => $item->id,
                'user_id' => Auth::user()->id,
                'payment_method' => $request->input('payment'),
                'delivery_postcode' => $request->input('delivery_postcode'),
                'delivery_address' => $request->input('delivery_address'),
            ]
        ]);

        return redirect($session->url);
    }

    public function store(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $session = Session::retrieve($request->query('session_id'));

        $item_id = $session->metadata->item_id;
        $user_id = $session->metadata->user_id;
        $payment = $session->metadata->payment_method;
        $delivery_postcode = $session->metadata->delivery_postcode;
        $delivery_address = $session->metadata->delivery_address;

        $item = Item::find($item_id);
        if ($item && !$item->sold_flag) {
            $item->update(['sold_flag' => true]);

            Purchase::create([
                'item_id' => $item_id,
                'buyer_id' => $user_id,
                'payment' => $payment,
                'delivery_postcode' => $delivery_postcode,
                'delivery_address' => $delivery_address,
            ]);
        }

        return redirect('mypage?page=buy');
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
