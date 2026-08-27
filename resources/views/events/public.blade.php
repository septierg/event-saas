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
                        href="#tickets"
                        class="rounded-md bg-white px-6 py-3 font-semibold text-gray-900 hover:bg-gray-200"
                    >
                        Acheter un billet
                    </a>

                    <a
                        href="#about"
                        class="rounded-md border border-white px-6 py-3 font-semibold text-white hover:bg-white/10"
                    >
                        Découvrir l'événement
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