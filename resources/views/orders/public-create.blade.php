<x-layouts.public :event="$event">
    <section class="py-16">
        <div class="mx-auto max-w-2xl px-6">

            <h1 class="text-3xl font-bold">
                Finaliser la commande
            </h1>

            <p class="mt-3 text-gray-600 dark:text-gray-300">
                {{ $event->title }}
            </p>

            <div class="mt-8 rounded-xl bg-gray-100 p-6 dark:bg-gray-800">
                <h2 class="text-xl font-semibold">
                    {{ $ticket->name }}
                </h2>

                <p class="mt-2">
                    Prix unitaire :
                    ${{ number_format($ticket->price, 2) }} CAD
                </p>
            </div>

            @if ($errors->any())
                <div class="mt-6 rounded-lg bg-red-50 p-4 text-red-700">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('public.orders.store', $event) }}"
                method="POST"
                class="mt-8 space-y-6"
            >
                @csrf

                <input
                    type="hidden"
                    name="ticket_type_id"
                    value="{{ $ticket->id }}"
                >

                <div>
                    <label for="first_name" class="block font-medium">
                        Prénom
                    </label>
                    <input
                        id="first_name"
                        name="first_name"
                        value="{{ old('first_name') }}"
                        required
                        autocomplete="given-name"
                        class="mt-2 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800"
                    >
                </div>

                <div>
                    <label for="last_name" class="block font-medium">
                        Nom
                    </label>
                    <input
                        id="last_name"
                        name="last_name"
                        value="{{ old('last_name') }}"
                        required
                        autocomplete="family-name"
                        class="mt-2 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800"
                    >
                </div>

                <div>
                    <label for="email" class="block font-medium">
                        Adresse courriel
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        class="mt-2 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800"
                    >
                </div>

                <div>
                    <label for="phone" class="block font-medium">
                        Téléphone (facultatif)
                    </label>
                    <input
                        id="phone"
                        type="tel"
                        name="phone"
                        value="{{ old('phone') }}"
                        autocomplete="tel"
                        class="mt-2 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800"
                    >
                </div>

                <div>
                    <label for="quantity" class="block font-medium">
                        Quantité
                    </label>
                    <input
                        id="quantity"
                        type="number"
                        name="quantity"
                        min="1"
                        max="10"
                        value="{{ old('quantity', 1) }}"
                        required
                        class="mt-2 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full rounded-md bg-gray-900 px-6 py-3 font-semibold text-white hover:bg-gray-700 dark:bg-white dark:text-gray-900"
                >
                    Continuer vers le paiement
                </button>
            </form>
        </div>
    </section>
</x-layouts.public>