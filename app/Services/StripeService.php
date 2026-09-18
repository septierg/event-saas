<?php

namespace App\Services;

use App\Models\Order;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeService
{
    public function createCheckoutSession(Order $order): Session
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        return Session::create([
            'mode' => 'payment',

            'line_items' => $order->items->map(function ($item) {
                return [
                    'price_data' => [
                        'currency' => 'cad',
                        'product_data' => [
                            'name' => $item->ticketType->name,
                        ],
                        'unit_amount' => (int) round($item->unit_price * 100),
                    ],
                    'quantity' => $item->quantity,
                ];
            })->values()->all(),

            'success_url' => route('orders.success', $order),
            'cancel_url' => route('orders.payment-cancelled', $order),

            'metadata' => [
                'order_id' => $order->id,
            ],
        ]);
    }
}