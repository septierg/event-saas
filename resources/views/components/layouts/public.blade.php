<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $title ?? config('app.name') }}
    </title>

    <script>
        window.setAppearance = function(appearance) {
            let setDark = () => document.documentElement.classList.add('dark')
            let setLight = () => document.documentElement.classList.remove('dark')

            if (appearance === 'system') {
                let media = window.matchMedia('(prefers-color-scheme: dark)')
                media.matches ? setDark() : setLight()
            } else if (appearance === 'dark') {
                setDark()
            } else {
                setLight()
            }
        }

        window.setAppearance(
            window.localStorage.getItem('appearance') || 'system'
        )
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-900 dark:bg-gray-950 dark:text-white antialiased">

    <div class="min-h-screen flex flex-col">

        {{-- Navigation --}}
        <header class="border-b border-gray-200 dark:border-gray-800">
            <nav class="max-w-7xl mx-auto px-6 py-4">

                <div class="flex items-center justify-between">

                    {{-- Logo / Event name --}}
                    <a
                        href="{{ route('home') }}"
                        class="text-xl font-bold"
                    >
                        {{ $event->title ?? config('app.name') }}
                    </a>

                    <div class="flex items-center gap-6">

                        {{-- Desktop navigation --}}
                        <div class="hidden md:flex items-center gap-8">

                            <a
                                href="#about"
                                class="text-sm font-medium hover:text-gray-500"
                            >
                                {{ __('public.about') }}
                            </a>

                            <a
                                href="#register"
                                class="text-sm font-medium hover:text-gray-500"
                            >
                                {{ __('public.register') }}
                            </a>

                            <a
                                href="#tickets"
                                class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white
                                    hover:bg-gray-700
                                    dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200"
                            >
                                {{ __('public.buy_ticket') }}
                            </a>

                        </div>

                        {{-- Language switcher --}}
                        <div class="flex items-center gap-2 text-sm font-medium">

                            <a
                                href="{{ route('locale', 'fr') }}"
                                class="{{ app()->getLocale() === 'fr'
                                    ? 'text-gray-900 dark:text-white'
                                    : 'text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}"
                            >
                                FR
                            </a>

                            <span class="text-gray-300 dark:text-gray-700">|</span>

                            <a
                                href="{{ route('locale', 'en') }}"
                                class="{{ app()->getLocale() === 'en'
                                    ? 'text-gray-900 dark:text-white'
                                    : 'text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}"
                            >
                                EN
                            </a>

                        </div>

                    </div>

                </div>

            </nav>
        </header>

        {{-- Content --}}
        <main class="flex-1">

            {{ $slot }}

        </main>

        {{-- Footer --}}
        <footer class="border-t border-gray-200 dark:border-gray-800">

            <div class="max-w-7xl mx-auto px-6 py-8">

                <div class="flex flex-col md:flex-row justify-between gap-4">

                    <div>
                        <p class="font-semibold">
                            {{ $event->title ?? config('app.name') }}
                        </p>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('public.footer_description') }} 
                        </p>
                    </div>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        © {{ date('Y') }}
                    </p>

                </div>

            </div>

        </footer>

    </div>

</body>

</html>