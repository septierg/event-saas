<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Event;
use App\Services\OrderService;
use Illuminate\Http\Request;
use App\Exceptions\OrderException;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $orders = Order::with(['customer', 'event'])
            ->latest()
            ->paginate(15);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load([
            'customer',
            'event',
            'items.ticketType',
        ]);

        return view('orders.show', compact('order'));
    }

    public function create()
    {
        $customers = Customer::orderBy('last_name')->get();

        $events = Event::query()
            ->whereIn('status', ['draft', 'published'])
            ->orderBy('start_date')
            ->with('ticketTypes')
            ->get();

        return view('orders.create', compact(
            'customers',
            'events'
        ));
    }

    public function store(Request $request, OrderService $orderService)
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'event_id' => ['required', 'exists:events,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.ticket_type_id' => ['required', 'integer'],
            'items.*.quantity' => ['required', 'integer', 'min:0'],
        ]);

        $customer = Customer::findOrFail($validated['customer_id']);

        $event = Event::findOrFail($validated['event_id']);

        try {
            $order = $orderService->create(
                $customer,
                $event,
                $validated['items']
            );
        } catch (OrderException $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('orders.show', $order)
            ->with('status', 'Order created successfully.');
    }

}