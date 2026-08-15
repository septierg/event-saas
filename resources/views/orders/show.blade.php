<x-layouts.app>

    <div class="mb-6">
        <a
            href="{{ route('orders.index') }}"
            class="text-sm text-blue-600 hover:text-blue-800"
        >
            ← Back to orders
        </a>

        <div class="mt-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                    Order {{ $order->reference }}
                </h1>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Created {{ $order->created_at->format('Y-m-d H:i') }}
                </p>
            </div>

            <span class="px-3 py-1 rounded-full text-sm bg-gray-100 dark:bg-gray-700">
                {{ $order->status->label() }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Customer --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">

            <h2 class="text-lg font-semibold mb-4">
                Customer
            </h2>

            <p class="font-medium">
                {{ $order->customer->first_name }}
                {{ $order->customer->last_name }}
            </p>

            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ $order->customer->email }}
            </p>

            @if ($order->customer->phone)
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ $order->customer->phone }}
                </p>
            @endif

        </div>

        {{-- Event --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">

            <h2 class="text-lg font-semibold mb-4">
                Event
            </h2>

            <p class="font-medium">
                {{ $order->event->title }}
            </p>

            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ $order->event->location }}
            </p>

        </div>

        {{-- Totals --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">

            <h2 class="text-lg font-semibold mb-4">
                Summary
            </h2>

            <div class="flex justify-between">
                <span>Subtotal</span>
                <span>${{ number_format($order->subtotal, 2) }}</span>
            </div>

            <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700 flex justify-between font-semibold">
                <span>Total</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </div>

        </div>

    </div>

    {{-- Order items --}}
    <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">

        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold">
                Tickets
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3">
                            Ticket
                        </th>

                        <th class="px-6 py-3">
                            Unit price
                        </th>

                        <th class="px-6 py-3">
                            Quantity
                        </th>

                        <th class="px-6 py-3">
                            Total
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @foreach ($order->items as $item)

                        <tr>

                            <td class="px-6 py-4 font-medium">
                                {{ $item->ticketType->name }}
                            </td>

                            <td class="px-6 py-4">
                                ${{ number_format($item->unit_price, 2) }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->quantity }}
                            </td>

                            <td class="px-6 py-4">
                                ${{ number_format($item->total, 2) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</x-layouts.app>