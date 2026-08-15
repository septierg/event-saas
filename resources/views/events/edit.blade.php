<x-layouts.app>

    <div class="mb-6">

        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
            <a
                href="{{ route('events.index') }}"
                class="hover:underline"
            >
                Events
            </a>

            <span>/</span>

            <a
                href="{{ route('events.show', $event) }}"
                class="hover:underline"
            >
                {{ $event->title }}
            </a>

            <span>/</span>

            <span>Edit</span>
        </div>

        <h1 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
            Edit Event
        </h1>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Update the information for this event.
        </p>

    </div>


    <div class="rounded-xl bg-white p-6 shadow-sm dark:bg-gray-800">

        <form
            method="POST"
            action="{{ route('events.update', $event) }}"
            class="space-y-6"
        >

            @csrf
            @method('PUT')


            {{-- Title --}}
            <div>

                <label
                    for="title"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                >
                    Title
                </label>

                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title', $event->title) }}"
                    required
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-black focus:ring-black dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                >

                @error('title')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Description --}}
            <div>

                <label
                    for="description"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                >
                    Description
                </label>

                <textarea
                    name="description"
                    id="description"
                    rows="5"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-black focus:ring-black dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                >{{ old('description', $event->description) }}</textarea>

                @error('description')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Location --}}
            <div>

                <label
                    for="location"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                >
                    Location
                </label>

                <input
                    type="text"
                    name="location"
                    id="location"
                    value="{{ old('location', $event->location) }}"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-black focus:ring-black dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                >

                @error('location')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Dates --}}
            <div class="grid gap-6 md:grid-cols-2">

                <div>

                    <label
                        for="start_date"
                        class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                    >
                        Start date
                    </label>

                    <input
                        type="datetime-local"
                        name="start_date"
                        id="start_date"
                        value="{{ old('start_date', $event->start_date?->format('Y-m-d\TH:i')) }}"
                        required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-black focus:ring-black dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >

                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <div>

                    <label
                        for="end_date"
                        class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                    >
                        End date
                    </label>

                    <input
                        type="datetime-local"
                        name="end_date"
                        id="end_date"
                        value="{{ old('end_date', $event->end_date?->format('Y-m-d\TH:i')) }}"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-black focus:ring-black dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    >

                    @error('end_date')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- Status --}}
            <div>

                <label
                    for="status"
                    class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                >
                    Status
                </label>

                <select
                    name="status"
                    id="status"
                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 focus:border-black focus:ring-black dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                >

                    <option
                        value="draft"
                        @selected(old('status', $event->status) === 'draft')
                    >
                        Draft
                    </option>

                    <option
                        value="published"
                        @selected(old('status', $event->status) === 'published')
                    >
                        Published
                    </option>

                    <option
                        value="cancelled"
                        @selected(old('status', $event->status) === 'cancelled')
                    >
                        Cancelled
                    </option>

                </select>

                @error('status')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 border-t border-gray-200 pt-6 dark:border-gray-700">

                <a
                    href="{{ route('events.show', $event) }}"
                    class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-black px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800 dark:bg-white dark:text-black dark:hover:bg-gray-200"
                >
                    Save changes
                </button>

            </div>

        </form>

    </div>

</x-layouts.app>