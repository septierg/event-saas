@extends('layouts.app')

@section('content') <div class="min-h-[70vh] flex items-center justify-center px-6 py-12"> <div class="w-full max-w-lg text-center">

```
        <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="2"
                 stroke="currentColor"
                 class="h-8 w-8">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            Payment cancelled
        </h1>

        <p class="mt-4 text-gray-600 dark:text-gray-400">
            Your payment was cancelled.
            No payment has been confirmed for this order.
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
                    Status
                </span>

                <span class="font-medium text-yellow-600 dark:text-yellow-400">
                    {{ $order->status->label() }}
                </span>
            </div>
        </div>

        <div class="mt-8 flex justify-center gap-3">
            <a href="{{ route('orders.show', $order) }}"
               class="inline-flex items-center rounded-lg border border-gray-300 px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-800">
                View order
            </a>

            <a href="{{ route('orders.create') }}"
               class="inline-flex items-center rounded-lg bg-gray-900 px-5 py-3 text-sm font-medium text-white hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                Try again
            </a>
        </div>

    </div>
</div>
```

@endsection
