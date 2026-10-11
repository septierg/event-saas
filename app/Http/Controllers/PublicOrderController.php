<?php

namespace App\Http\Controllers;

use App\Exceptions\OrderException;
use App\Models\Customer;
use App\Models\Event;
use App\Services\OrderService;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Stripe\Exception\ApiErrorException;

class PublicOrderController extends Controller
{
    /**
     * Display the public checkout form.
     */
    public function create(Request $request, Event $event): View
    {
        abort_unless($event->status === 'published', 404);

        $ticket = $event->ticketTypes()
            ->whereKey($request->query('ticket_type'))
            ->where('status', 'active')
            ->firstOrFail();

        $now = now();

        abort_if(
            ($ticket->sales_start && $now->lt($ticket->sales_start)) ||
            ($ticket->sales_end && $now->gt($ticket->sales_end)) ||
            ($ticket->quantity !== null && $ticket->quantity < 1),
            404,
            'Ce billet n’est pas disponible à la vente.'
        );

        return view('orders.public-create', [
            'event' => $event,
            'ticket' => $ticket,
        ]);
    }

    /**
     * Create a public order and redirect to Stripe Checkout.
     */
    public function store(
        Request $request,
        Event $event,
        OrderService $orderService,
        StripeService $stripeService
    ): RedirectResponse {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'ticket_type_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        if ($event->status !== 'published') {
            abort(404);
        }

        // Ensure that the selected ticket belongs to this event.
        $ticket = $event->ticketTypes()
            ->whereKey($validated['ticket_type_id'])
            ->firstOrFail();

        $customer = Customer::firstOrCreate(
            ['email' => $validated['email']],
            [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'] ?? null,
            ]
        );

        try {
            $order = $orderService->create(
                $customer,
                $event,
                [[
                    'ticket_type_id' => $ticket->id,
                    'quantity' => $validated['quantity'],
                ]]
            );
        } catch (OrderException $e) {
            return back()
                ->withInput()
                ->withErrors(['ticket_type_id' => $e->getMessage()]);
        }

        try {
            $checkoutSession = $stripeService->createCheckoutSession($order);
        } catch (ApiErrorException $e) {
            // Restore inventory if Stripe cannot create the session.
            $orderService->cancel($order);

            report($e);

            return back()
                ->withInput()
                ->withErrors([
                    'checkout' => 'Le paiement est temporairement indisponible. Réessaie dans quelques instants.',
                ]);
        }

        $order->update([
            'stripe_checkout_session_id' => $checkoutSession->id,
        ]);

        return redirect()->away($checkoutSession->url);
    }
}