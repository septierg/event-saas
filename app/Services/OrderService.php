<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Enums\OrderStatus;
use App\Exceptions\OrderException;

class OrderService
{
    public function create(
        Customer $customer,
        Event $event,
        array $items
    ): Order {
        return DB::transaction(function () use ($customer, $event, $items) {

            $subtotal = 0;

            if ($event->status !== 'published') {//check event status
                throw new OrderException(
                    "The event {$event->title} is not available for sale."
                );
            }
            
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
                    ->whereKey($item['ticket_type_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($ticketType->status !== 'active') {//check ticket status
                    throw new OrderException(
                        "The ticket type {$ticketType->name} is not active."
                    );
                }

                $now = now();

                if (
                    ($ticketType->sales_start && $now->lt($ticketType->sales_start)) ||
                    ($ticketType->sales_end && $now->gt($ticketType->sales_end))
                ) {
                    throw new OrderException(//check ticket sale date and end
                        "Ticket sales are not currently available for {$ticketType->name}."
                    );
                }

                $quantity = (int) $item['quantity'];

                if ($quantity < 1) {
                    continue;
                }

                if (
                    $ticketType->quantity !== null &&
                    $quantity > $ticketType->quantity
                ) {
                    throw new OrderException(//check ticket quatity
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

                if ($ticketType->quantity !== null) {
                    $ticketType->decrement('quantity', $quantity);
                }

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

    public function cancel(Order $order): Order
    {
        return DB::transaction(function () use ($order) {

            if (! $order->status->isPending()) {
                throw new OrderException(
                    "Order {$order->reference} cannot be cancelled."
                );
            }

            $order->load('items');

            foreach ($order->items as $item) {

                $ticketType = $order->event->ticketTypes()
                    ->whereKey($item->ticket_type_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($ticketType->quantity !== null) {
                    $ticketType->increment('quantity', $item->quantity);
                }
            }

            $order->update([
                'status' => OrderStatus::CANCELLED,
            ]);

            return $order->fresh([
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