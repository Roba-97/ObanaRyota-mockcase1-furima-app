<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;

class DetailController extends Controller
{
    public function index(Item $item)
    {
        return view('detail', ['item' => $item]);
    }

    public function comment(Item $item)
    {
        return view('detail', ['item' => $item]);
    }
}
