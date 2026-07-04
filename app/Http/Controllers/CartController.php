<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService) {}
    public function store(Request $request, Product $product)
    {
        $this->cartService->addItem($product, (int) $request->input('quantity', 1));
        return back()->with('success', 'Produto adicionado ao carrinho.');
    }
}
