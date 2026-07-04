<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(protected CartService $cartService, protected OrderService $orderService) {}

    public function store(CheckoutRequest $request)
    {
        $cart = $this->cartService->getCurrentCart();
        $address = Address::where('user_id', Auth::id())->findOrFail($request->address_id);

        try {
            $order = $this->orderService->createFromCart(
                Auth::user(), $cart, $address, $request->payment_method, $request->coupon_code
            );
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('orders.show', $order)->with('success', 'Pedido realizado!');
    }
}
