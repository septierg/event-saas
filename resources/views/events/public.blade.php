<x-layouts.public :event="$event">

    {{-- Hero --}}
    <section class="relative min-h-[80vh] flex items-center">

        <div class="absolute inset-0">
            <img
                src="{{ $event->image
                    ? asset('storage/' . $event->image)
                    : 'https://images.unsplash.com/photo-1547153760-18fc86324498'
                }}"
                class="w-full h-full object-cover"
                alt="{{ $event->title }}"
            >

            <div class="absolute inset-0 bg-black/60"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-6 py-24 w-full">

            <div class="max-w-3xl text-white">

                <p class="uppercase tracking-[0.3em] text-sm font-semibold">
                    {{ $event->location }}
                </p>

                <h1 class="mt-4 text-5xl md:text-7xl font-bold tracking-tight">
                    {{ $event->title }}
                </h1>

                <p class="mt-6 text-lg md:text-xl text-white/80">
                    {{ $event->start_date->format('d F Y') }}
                </p>

                <div class="mt-8 flex flex-wrap gap-4">

                    <a
                        href="#register"
                        class="rounded-md bg-white px-6 py-3 font-semibold text-gray-900 hover:bg-gray-200"
                    >
                        Register
                    </a>

                    <a
                        href="#tickets"
                        class="rounded-md border border-white px-6 py-3 font-semibold text-white hover:bg-white/10"
                    >
                        Acheter un billet
                    </a>

                </div>

            </div>

        </div>

    </section>

    {{-- About --}}
    <section id="about" class="py-24">
        <div class="max-w-5xl mx-auto px-6">

            <div class="max-w-3xl">

                <p class="text-sm font-semibold uppercase tracking-widest">
                    L'événement
                </p>

                <h2 class="mt-3 text-3xl md:text-4xl font-bold">
                    C'est quoi {{ $event->title }} ?
                </h2>

                <div class="mt-8 text-lg leading-8 text-gray-600 dark:text-gray-300">
                    {!! nl2br(e($event->description)) !!}
                </div>

            </div>

        </div>
    </section>

    {{-- Registration --}}
    <section id="register" class="py-24">
        <div class="max-w-2xl mx-auto px-6">

            <div class="text-center">

                <p class="text-sm font-semibold uppercase tracking-widest">
                    Registration
                </p>

                <h2 class="mt-3 text-3xl md:text-4xl font-bold">
                    Inscrivez-vous au jam
                </h2>

                <p class="mt-4 text-gray-600 dark:text-gray-300">
                    Entrez vos informations pour participer à l'événement.
                </p>

            </div>

            @if (session('registration_success'))
                <div class="mt-8 rounded-lg bg-green-50 dark:bg-green-900/30 p-4 text-green-700 dark:text-green-300">
                    {{ session('registration_success') }}
                </div>
            @endif

            <form
                action="{{ route('events.participants.store', $event) }}"
                method="POST"
                class="mt-10 space-y-6"
            >

                @csrf

                <div>
                    <label
                        for="first_name"
                        class="block text-sm font-medium"
                    >
                        Prénom
                    </label>

                    <input
                        type="text"
                        id="first_name"
                        name="first_name"
                        value="{{ old('first_name') }}"
                        required
                        class="mt-2 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800"
                    >

                    @error('first_name')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="last_name"
                        class="block text-sm font-medium"
                    >
                        Nom
                    </label>

                    <input
                        type="text"
                        id="last_name"
                        name="last_name"
                        value="{{ old('last_name') }}"
                        required
                        class="mt-2 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800"
                    >

                    @error('last_name')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="alias"
                        class="block text-sm font-medium"
                    >
                        Alias / Nom de danseur
                    </label>

                    <input
                        type="text"
                        id="alias"
                        name="alias"
                        value="{{ old('alias') }}"
                        required
                        class="mt-2 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800"
                    >

                    @error('alias')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full rounded-md bg-gray-900 px-6 py-3 font-semibold text-white hover:bg-gray-700 dark:bg-white dark:text-gray-900"
                >
                    Register
                </button>

            </form>

        </div>
    </section>

    {{-- Participants --}}

    {{-- Tickets --}}
    <section id="tickets" class="bg-gray-100 dark:bg-gray-900 py-24">
        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center">

                <p class="text-sm font-semibold uppercase tracking-widest">
                    Billetterie
                </p>

                <h2 class="mt-3 text-3xl md:text-4xl font-bold">
                    Choisissez votre billet
                </h2>

            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-3">

                @foreach ($event->ticketTypes as $ticket)

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">

                        <h3 class="text-xl font-semibold">
                            {{ $ticket->name }}
                        </h3>

                        <p class="mt-4 text-3xl font-bold">
                            ${{ number_format($ticket->price, 2) }}
                        </p>

                        @if ($ticket->description)
                            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $ticket->description }}
                            </p>
                        @endif

                        <a
                            href="{{ route('orders.create') }}"
                            class="mt-6 block w-full rounded-md bg-gray-900 px-4 py-3 text-center font-semibold text-white hover:bg-gray-700 dark:bg-white dark:text-gray-900"
                        >
                            Acheter
                        </a>

                    </div>

                @endforeach

            </div>

        </div>
</section>

</x-layouts.public>