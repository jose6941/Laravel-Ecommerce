<?php

namespace App\Services;

class CartService
{
    public function getCurrentCart(): Cart
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        }

        return Cart::firstOrCreate(['session_id' => Session::getId()]);
    }

    public function addItem(Product $product, int $quantity = 1): CartItem
    {
        $cart = $this->getCurrentCart();

        if ($product->stock < $quantity) {
            throw new \DomainException("Estoque insuficiente para {$product->name}.");
        }

        $item = $cart->items()->firstOrNew(['product_id' => $product->id]);
        $item->quantity = $item->exists ? $item->quantity + $quantity : $quantity;
        $item->unit_price = $product->final_price; // "fotografa" o preço atual
        $item->cart_id = $cart->id;
        $item->save();

        return $item;
    }

    public function mergeGuestCartIntoUser(string $sessionId, int $userId): void
    {
        $guestCart = Cart::where('session_id', $sessionId)->first();
        if (! $guestCart) return;

        $userCart = Cart::firstOrCreate(['user_id' => $userId]);

        foreach ($guestCart->items as $guestItem) {
            $userCart->items()->create([
                'product_id' => $guestItem->product_id,
                'quantity' => $guestItem->quantity,
                'unit_price' => $guestItem->unit_price,
            ]);
        }

        $guestCart->delete();
    }
}
