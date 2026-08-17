<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Enums\OrderStatus;

class OrderService
{
    public function create(
        Customer $customer,
        Event $event,
        array $items
    ): Order {
        return DB::transaction(function () use ($customer, $event, $items) {

            $subtotal = 0;

            $order = Order::create([
                'customer_id' => $customer->id,
                'event_id' => $event->id,
                'reference' => $this->generateReference(),
                'status' => OrderStatus::PENDING,
                'subtotal' => 0,
                'total' => 0,
            ]);

            foreach ($items as $item) {

                $ticketType = $event->ticketTypes()
                    ->findOrFail($item['ticket_type_id']);

                $quantity = (int) $item['quantity'];

                if ($quantity < 1) {
                    continue;
                }

                if ($ticketType->quantity !== null && $quantity > $ticketType->quantity) {
                    throw new \RuntimeException(
                        "Not enough tickets available for {$ticketType->name}."
                    );
                }

                $unitPrice = $ticketType->price;
                $itemTotal = $unitPrice * $quantity;

                $order->items()->create([
                    'ticket_type_id' => $ticketType->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total' => $itemTotal,
                ]);

                $subtotal += $itemTotal;
            }

            $order->update([
                'subtotal' => $subtotal,
                'total' => $subtotal,
            ]);

            return $order->load([
                'customer',
                'event',
                'items.ticketType',
            ]);
        });
    }

    protected function generateReference(): string
    {
        return 'ORD-' . now()->format('Y') . '-' . strtoupper(
            Str::random(6)
        );
    }
}