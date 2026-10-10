
<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use UnexpectedValueException;

class StripeWebhookController extends Controller
{
    public function handle(Request $request): Response
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $signature ?? '',
                $secret ?? ''
            );
        } catch (UnexpectedValueException | SignatureVerificationException $e) {
            return response('Invalid webhook signature or payload.', 400);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            if ($session->payment_status === 'paid') {
                $orderId = $session->metadata->order_id ?? null;

                if ($orderId) {
                    $order = Order::find($orderId);

                    if ($order && $order->status->isPending()) {
                        $order->update([
                            'status' => OrderStatus::PAID,
                        ]);
                    }
                }
            }
        }

        return response('Webhook received.', 200);
    }
}