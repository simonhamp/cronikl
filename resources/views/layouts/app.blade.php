<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Cronikl</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="antialiased relative grid grid-cols-1 min-h-screen bg-gray-100 dark:bg-gray-900 selection:bg-green-300 selection:text-black">
        <div class="mx-auto p-6 lg:p-8">
            <img src="/cronikl.svg" class="w-64 mb-8 pointer-events-none select-none" />

            <div>
                {{ $slot }}
            </div>

            <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
{{--                    <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-left">--}}
{{--                        <div class="flex items-center gap-4">--}}
{{--                            <a href="https://github.com/sponsors/simonhamp" target="_external" class="group inline-flex items-center hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="-mt-px mr-1 w-5 h-5 stroke-gray-400 dark:stroke-gray-600 group-hover:stroke-gray-600 dark:group-hover:stroke-gray-400">--}}
{{--                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />--}}
{{--                                </svg>--}}
{{--                                Sponsor--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}

            </div>
        </div>

        <div class="mx-auto p-6 lg:p-8 text-sm text-gray-500 dark:text-gray-400 sm:ml-0 flex items-end">
            <span>
                &copy; Simon Hamp {{ date('Y') }}
                - Cronikl v{{ config('nativephp.version') }}
                - Laravel v{{ Illuminate\Foundation\Application::VERSION }}
                - PHP v{{ PHP_VERSION }}
                - <a href="https://github.com/simonhamp/cronikl" target="_blank">Support</a>
            </span>
        </div>

        @livewireScripts
    </body>
</html>
