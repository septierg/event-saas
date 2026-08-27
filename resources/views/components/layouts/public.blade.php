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

                    <a
                        href="#"
                        class="text-xl font-bold"
                    >
                        {{ $event->title ?? config('app.name') }}
                    </a>

                    <div class="hidden md:flex items-center gap-8">

                        <a
                            href="#about"
                            class="text-sm font-medium hover:text-gray-500"
                        >
                            À propos
                        </a>

                        <a
                            href="#register"
                            class="text-sm font-medium hover:text-gray-500"
                        >
                            S'inscrire
                        </a>

                        <a
                            href="#tickets"
                            class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200"
                        >
                            Acheter un billet
                        </a>

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
                            Une expérience créée pour la communauté.
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