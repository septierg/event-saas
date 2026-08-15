<x-layouts.app>

    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
            Orders
        </h1>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Manage ticket orders for your events.
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 font-medium">
                            Reference
                        </th>

                        <th class="px-6 py-3 font-medium">
                            Customer
                        </th>

                        <th class="px-6 py-3 font-medium">
                            Event
                        </th>

                        <th class="px-6 py-3 font-medium">
                            Status
                        </th>

                        <th class="px-6 py-3 font-medium">
                            Total
                        </th>

                        <th class="px-6 py-3 font-medium">
                            Date
                        </th>

                        <th class="px-6 py-3 font-medium">
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
                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400"
                                >
                                    View
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