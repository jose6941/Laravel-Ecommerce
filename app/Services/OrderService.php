<?php

namespace App\Services;

class OrderService
{
    public function __construct(protected CartService $cartService) {}

    public function createFromCart(User $user, Cart $cart, Address $address, string $paymentMethod, ?string $couponCode = null): Order
    {
        if ($cart->items->isEmpty()) {
            throw new \DomainException('O carrinho está vazio.');
        }

        // tudo dentro de uma transação: se algo falhar no meio do caminho
        // (ex: estoque acabou), NADA é salvo — evita pedido "pela metade"
        return DB::transaction(function () use ($user, $cart, $address, $paymentMethod, $couponCode) {
            $subtotal = $cart->items->sum(fn ($item) => $item->unit_price * $item->quantity);

            $discount = 0;
            $coupon = null;
            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->first();
                if (! $coupon || ! $coupon->isValid()) {
                    throw new \DomainException('Cupom inválido ou expirado.');
                }
                $discount = $coupon->calculateDiscount($subtotal);
            }

            $order = Order::create([
                'user_id' => $user->id,
                'coupon_id' => $coupon?->id,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $subtotal - $discount,
                'payment_method' => $paymentMethod,
                // snapshot do endereço: se o cliente editar depois, o pedido não muda
                'shipping_address' => $address->only([
                    'street', 'number', 'neighborhood', 'city', 'state', 'zip_code',
                ]),
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name, // snapshot do nome
                    'unit_price' => $item->unit_price,
                    'quantity' => $item->quantity,
                    'total' => $item->unit_price * $item->quantity,
                ]);

                $item->product()->decrement('stock', $item->quantity); // baixa o estoque
            }

            $this->cartService->clear($cart);

            return $order;
        });
    }

    public function updateStatus(Order $order, string $newStatus): Order
    {
    $allowed = [
        'pending' => ['paid', 'canceled'],
        'paid' => ['processing', 'canceled'],
        'processing' => ['shipped', 'canceled'],
        'shipped' => ['delivered'],
        'delivered' => [],
        'canceled' => [],
    ];

    if (! in_array($newStatus, $allowed[$order->status] ?? [], true)) {
        throw new \DomainException("Não é possível mudar de \"{$order->status}\" para \"{$newStatus}\".");
    }

    $order->update(['status' => $newStatus]);

    return $order;
}
}
