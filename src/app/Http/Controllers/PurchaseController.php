<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Item;

class PurchaseController extends Controller
{
    public function index(Item $item)
    {
        return view('purchase', ['item' => $item]);
    }

    public function store()
    {
        return view('purchase');
    }

    public function edit()
    {
        return view('address');
    }
}
