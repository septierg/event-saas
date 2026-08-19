<x-layouts.app>

    <div
        class="max-w-5xl mx-auto"
        x-data="{
            selectedEvent: '{{ old('event_id', $events->first()?->id) }}',

            get tickets() {
                const events = @js($events);

                const event = events.find(
                    event => event.id == this.selectedEvent
                );

                return event ? event.ticket_types : [];
            },

            get total() {
                return this.tickets.reduce((total, ticket) => {
                    const quantityInput = document.querySelector(
                        `input[name='items[${ticket.id}][quantity]']`
                    );

                    const quantity = quantityInput
                        ? parseInt(quantityInput.value) || 0
                        : 0;

                    return total + (parseFloat(ticket.price) * quantity);
                }, 0);
            }
        }"
    >

        <form method="POST" action="{{ route('orders.store') }}">
            @csrf

            @if (session('error'))
                <div class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-700 dark:bg-red-900/30 dark:text-red-300">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
                    Nouvelle commande
                </h1>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Créer une commande pour un événement.
                </p>
            </div>

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700 dark:border-red-800 dark:bg-red-900/20 dark:text-red-300">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">

                {{-- Customer --}}
                <div class="mb-6">
                    <label
                        for="customer_id"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                    >
                        Client
                    </label>

                    <select
                        id="customer_id"
                        name="customer_id"
                        required
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >
                        <option value="">
                            Sélectionner un client
                        </option>

                        @foreach ($customers as $customer)
                            <option
                                value="{{ $customer->id }}"
                                @selected(old('customer_id') == $customer->id)
                            >
                                {{ $customer->first_name }}
                                {{ $customer->last_name }}
                                — {{ $customer->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Event --}}
                <div class="mb-8">
                    <label
                        for="event_id"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                    >
                        Événement
                    </label>

                    <select
                        id="event_id"
                        name="event_id"
                        x-model="selectedEvent"
                        required
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}">
                                {{ $event->title }}
                                — {{ $event->start_date->format('d/m/Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tickets --}}
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Types de billets
                        </h2>

                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Sélectionnez les quantités
                        </span>
                    </div>

                    {{-- Tickets disponibles --}}
                    <template x-if="tickets.length > 0">
                        <div class="space-y-3">

                            <template x-for="ticket in tickets" :key="ticket.id">

                                <div
                                    class="flex items-center justify-between border border-gray-200 dark:border-gray-700 rounded-lg p-4"
                                >

                                    <div>
                                        <div
                                            class="font-medium text-gray-900 dark:text-white"
                                            x-text="ticket.name"
                                        ></div>

                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            $<span x-text="parseFloat(ticket.price).toFixed(2)"></span>
                                        </div>

                                        <template x-if="ticket.quantity !== null">
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                <span x-text="ticket.quantity"></span>
                                                disponibles
                                            </div>
                                        </template>
                                    </div>

                                    <div>
                                        <label
                                            :for="'ticket-' + ticket.id"
                                            class="sr-only"
                                        >
                                            Quantité
                                        </label>

                                        <input
                                            type="number"
                                            :id="'ticket-' + ticket.id"
                                            :name="'items[' + ticket.id + '][quantity]'"
                                            value="0"
                                            min="0"
                                            :max="ticket.quantity"
                                            class="w-24 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                        >

                                        <input
                                            type="hidden"
                                            :name="'items[' + ticket.id + '][ticket_type_id]'"
                                            :value="ticket.id"
                                        >
                                    </div>

                                </div>

                            </template>

                        </div>
                    </template>

                    {{-- Aucun ticket --}}
                    <template x-if="tickets.length === 0">
                        <div class="rounded-lg border border-dashed border-gray-300 dark:border-gray-700 p-8 text-center">

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Aucun billet configuré pour cet événement.
                            </p>

                        </div>
                    </template>
                </div>

                {{-- Total --}}
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">

                    <div class="flex items-center justify-between">

                        <span class="text-lg font-semibold text-gray-900 dark:text-white">
                            Total
                        </span>

                        <span class="text-2xl font-bold text-gray-900 dark:text-white">
                            $<span x-text="total.toFixed(2)"></span>
                        </span>

                    </div>

                </div>

                {{-- Actions --}}
                <div class="mt-6 flex justify-end gap-3">

                    <a
                        href="{{ route('orders.index') }}"
                        class="px-4 py-2 rounded-md border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700"
                    >
                        Annuler
                    </a>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-gray-900 text-white rounded-md hover:bg-gray-700"
                    >
                        Créer la commande
                    </button>

                </div>

            </div>

        </form>

    </div>

</x-layouts.app>