<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-[#F7EADF]">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#F7EADF]">
            <div class="mb-4">
                <!-- Logo -->
                <a href="/" class="flex items-center justify-center">
                    <x-application-logo class="w-20 h-20 fill-current text-[#735C49]" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-6 py-6 bg-white shadow-lg rounded-lg border border-[#735C49]/30 overflow-hidden">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center text-sm text-[#735C49]">
                &copy; {{ date('Y') }} Hekkensluiter Systeem
            </div>
        </div>
    </body>
</html>