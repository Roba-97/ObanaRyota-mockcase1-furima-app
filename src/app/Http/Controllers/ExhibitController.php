<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Condition;

class ExhibitController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('exhibit', compact('categories', 'conditions'));
    }

    public function store()
    {
        return view('exhibit');
    }
}
