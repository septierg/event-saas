<x-layouts.app>

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                        {{ $event->title }}
                    </h1>

                    <span
                        class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                        {{ $event->status === 'published'
                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                            : ($event->status === 'draft'
                                ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'
                                : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200') }}">
                        {{ ucfirst($event->status) }}
                    </span>
                </div>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $event->location }}
                </p>
            </div>

            <div class="flex gap-2">

                <a
                    href="{{ route('events.edit', $event) }}"
                    class="inline-flex items-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                    Edit event
                </a>

                <a
                    href="{{ route('events.index') }}"
                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700">
                    Back
                </a>

            </div>

        </div>


        {{-- Event information --}}
        <div class="grid gap-6 lg:grid-cols-3">

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 lg:col-span-2">

                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Event information
                </h2>

                <dl class="mt-5 grid gap-5 sm:grid-cols-2">

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Start date
                        </dt>

                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $event->start_date?->format('M d, Y H:i') }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            End date
                        </dt>

                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $event->end_date?->format('M d, Y H:i') }}
                        </dd>
                    </div>

                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Description
                        </dt>

                        <dd class="mt-1 whitespace-pre-line text-sm text-gray-700 dark:text-gray-300">
                            {{ $event->description }}
                        </dd>
                    </div>

                </dl>

            </div>


            {{-- Quick stats --}}
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">

                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Overview
                </h2>

                <div class="mt-5 space-y-5">

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Ticket types
                        </p>

                        <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ $event->ticketTypes->count() }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Total capacity
                        </p>

                        <p class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                            {{ $event->ticketTypes->sum('quantity') }}
                        </p>
                    </div>

                </div>

            </div>

        </div>


        {{-- Ticket types --}}
        <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

            <div class="flex flex-col gap-4 border-b border-gray-200 p-6 sm:flex-row sm:items-center sm:justify-between dark:border-gray-700">

                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Ticket types
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Manage the tickets available for this event.
                    </p>
                </div>

                <button
                    type="button"
                    onclick="document.getElementById('ticket-type-form').classList.toggle('hidden')"
                    class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200">
                    + Add ticket type
                </button>

            </div>


            {{-- Add ticket type form --}}
            <div id="ticket-type-form" class="hidden border-b border-gray-200 p-6 dark:border-gray-700">

                <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                    Add ticket type
                </h3>

                <form
                    method="POST"
                    action="{{ route('events.ticket-types.store', $event) }}"
                    class="mt-5 space-y-5">

                    @csrf

                    <div class="grid gap-5 sm:grid-cols-2">

                        <div>
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Name
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Early Bird"
                                required
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>


                        <div>
                            <label for="price"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Price
                            </label>

                            <input
                                type="number"
                                id="price"
                                name="price"
                                value="{{ old('price') }}"
                                min="0"
                                step="0.01"
                                placeholder="25.00"
                                required
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>


                        <div>
                            <label for="quantity"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Quantity
                            </label>

                            <input
                                type="number"
                                id="quantity"
                                name="quantity"
                                value="{{ old('quantity') }}"
                                min="1"
                                placeholder="100"
                                required
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>


                        <div>
                            <label for="status"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Status
                            </label>

                            <select
                                id="status"
                                name="status"
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">

                                <option value="active">
                                    Active
                                </option>

                                <option value="inactive">
                                    Inactive
                                </option>

                            </select>
                        </div>


                        <div>
                            <label for="sales_start"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Sales start
                            </label>

                            <input
                                type="datetime-local"
                                id="sales_start"
                                name="sales_start"
                                value="{{ old('sales_start') }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>


                        <div>
                            <label for="sales_end"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Sales end
                            </label>

                            <input
                                type="datetime-local"
                                id="sales_end"
                                name="sales_end"
                                value="{{ old('sales_end') }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>


                        <div class="sm:col-span-2">
                            <label for="description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Description
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="3"
                                placeholder="Describe what this ticket includes..."
                                class="mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('description') }}</textarea>
                        </div>

                    </div>


                    <div class="flex justify-end gap-3">

                        <button
                            type="button"
                            onclick="document.getElementById('ticket-type-form').classList.add('hidden')"
                            class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800 dark:bg-white dark:text-gray-900">
                            Create ticket type
                        </button>

                    </div>

                </form>

            </div>


            {{-- Ticket type list --}}
            <div class="divide-y divide-gray-200 dark:divide-gray-700">

                @forelse ($event->ticketTypes as $ticketType)

                    <div class="p-6">

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                            <div>
                                <div class="flex items-center gap-3">

                                    <h3 class="font-semibold text-gray-900 dark:text-white">
                                        {{ $ticketType->name }}
                                    </h3>

                                    <span
                                        class="rounded-full px-2.5 py-0.5 text-xs font-medium
                                        {{ $ticketType->status === 'active'
                                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                            : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                                        {{ ucfirst($ticketType->status) }}
                                    </span>

                                </div>

                                @if ($ticketType->description)
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $ticketType->description }}
                                    </p>
                                @endif
                            </div>


                            <div class="flex items-center gap-6">

                                <div class="text-right">
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        ${{ number_format($ticketType->price, 2) }}
                                    </p>

                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $ticketType->quantity }} tickets
                                    </p>
                                </div>

                                <div class="flex items-center gap-2">

                                    {{-- Edit --}}
                                    <button
                                        type="button"
                                        onclick="document.getElementById('edit-ticket-{{ $ticketType->id }}').classList.toggle('hidden')"
                                        class="inline-flex items-center rounded-lg border border-gray-300 p-2 text-gray-600 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
                                        title="Edit ticket type">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M12 20h9" />
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z" />
                                        </svg>

                                    </button>


                                    {{-- Delete --}}
                                    <form
                                        method="POST"
                                        action="{{ route('events.ticket-types.destroy', [$event, $ticketType]) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this ticket type?');">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex items-center rounded-lg border border-red-200 p-2 text-red-600 hover:bg-red-50 dark:border-red-900 dark:hover:bg-red-900/20"
                                            title="Delete ticket type">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2">
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4h8v2" />
                                                <path d="M19 6l-1 14H6L5 6" />
                                                <path d="M10 11v5" />
                                                <path d="M14 11v5" />
                                            </svg>

                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div
                        id="edit-ticket-{{ $ticketType->id }}"
                        class="mt-6 hidden rounded-lg border border-gray-200 bg-gray-50 p-5 dark:border-gray-700 dark:bg-gray-900">

                        <h4 class="font-semibold text-gray-900 dark:text-white">
                            Edit {{ $ticketType->name }}
                        </h4>

                        <form
                            method="POST"
                            action="{{ route('events.ticket-types.update', [$event, $ticketType]) }}"
                            class="mt-5 space-y-5">

                            @csrf
                            @method('PUT')

                            <div class="grid gap-5 sm:grid-cols-2">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Name
                                    </label>

                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ $ticketType->name }}"
                                        required
                                        class="mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Price
                                    </label>

                                    <input
                                        type="number"
                                        name="price"
                                        value="{{ $ticketType->price }}"
                                        min="0"
                                        step="0.01"
                                        required
                                        class="mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Quantity
                                    </label>

                                    <input
                                        type="number"
                                        name="quantity"
                                        value="{{ $ticketType->quantity }}"
                                        min="1"
                                        required
                                        class="mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Status
                                    </label>

                                    <select
                                        name="status"
                                        class="mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">

                                        <option value="active" @selected($ticketType->status === 'active')>
                                            Active
                                        </option>

                                        <option value="inactive" @selected($ticketType->status === 'inactive')>
                                            Inactive
                                        </option>

                                    </select>
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Sales start
                                    </label>

                                    <input
                                        type="datetime-local"
                                        name="sales_start"
                                        value="{{ $ticketType->sales_start?->format('Y-m-d\TH:i') }}"
                                        class="mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Sales end
                                    </label>

                                    <input
                                        type="datetime-local"
                                        name="sales_end"
                                        value="{{ $ticketType->sales_end?->format('Y-m-d\TH:i') }}"
                                        class="mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>


                                <div class="sm:col-span-2">

                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Description
                                    </label>

                                    <textarea
                                        name="description"
                                        rows="3"
                                        class="mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ $ticketType->description }}</textarea>

                                </div>

                            </div>


                            <div class="flex justify-end gap-3">

                                <button
                                    type="button"
                                    onclick="document.getElementById('edit-ticket-{{ $ticketType->id }}').classList.add('hidden')"
                                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                                    Cancel
                                </button>

                                <button
                                    type="submit"
                                    class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800 dark:bg-white dark:text-gray-900">
                                    Save changes
                                </button>

                            </div>

                        </form>

                    </div>      

                @empty

                    <div class="p-10 text-center">

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            No ticket types have been created for this event yet.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</x-layouts.app>