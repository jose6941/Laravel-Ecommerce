<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::active()->featured()->with('category')->take(8)->get();
        $categories = Category::active()->rootLevel()->take(6)->get();

        return view('home', compact('featuredProducts', 'categories'));
    }
}
