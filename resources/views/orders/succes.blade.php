@extends('layouts.app')

@section('content') <div class="min-h-[70vh] flex items-center justify-center px-6 py-12"> <div class="w-full max-w-lg text-center">

```
        <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400">
            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="2"
                 stroke="currentColor"
                 class="h-8 w-8">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            Payment successful
        </h1>

        <p class="mt-4 text-gray-600 dark:text-gray-400">
            Thank you for your purchase.
            Your order has been received.
        </p>

        <div class="mt-8 rounded-lg border border-gray-200 bg-white p-6 text-left shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">
                    Order reference
                </span>

                <span class="font-medium text-gray-900 dark:text-white">
                    {{ $order->reference }}
                </span>
            </div>

            <div class="mt-4 flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">
                    Total
                </span>

                <span class="font-semibold text-gray-900 dark:text-white">
                    ${{ number_format($order->total, 2) }} CAD
                </span>
            </div>

            <div class="mt-4 flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">
                    Status
                </span>

                <span class="font-medium text-yellow-600 dark:text-yellow-400">
                    {{ $order->status->label() }}
                </span>
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('orders.show', $order) }}"
               class="inline-flex items-center rounded-lg bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                View my order
            </a>
        </div>

    </div>
</div>
```

@endsection
