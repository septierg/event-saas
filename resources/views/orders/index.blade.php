<x-layouts.app>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                Orders
            </h1>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Manage ticket orders for your events.
            </p>

        </div>

        <a
            href="{{ route('orders.create') }}"
            class="inline-flex items-center rounded-lg bg-black px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800 dark:bg-white dark:text-black dark:hover:bg-gray-200"
        >
            + Create order
        </a>
         
    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-gray-800">

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Reference
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Customer
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Event
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Status
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Total
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Date
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    @forelse ($orders as $order)

                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">

                            <td class="px-6 py-4 font-medium">
                                {{ $order->reference }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $order->customer->first_name }}
                                {{ $order->customer->last_name }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $order->event->title }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $order->status->label() }}
                            </td>

                            <td class="px-6 py-4">
                                ${{ number_format($order->total, 2) }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $order->created_at->format('Y-m-d H:i') }}
                            </td>

                            <td class="px-6 py-4">
                                <a
                                    href="{{ route('orders.show', $order) }}"
                                    class="inline-flex items-center justify-center rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        class="h-5 w-5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                No orders found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($orders->hasPages())
            <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                {{ $orders->links() }}
            </div>
        @endif

    </div>

</x-layouts.app>