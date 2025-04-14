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
    <body class="font-sans antialiased bg-[#F7EADF]">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-md">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        <h1 class="text-xl font-semibold text-[#735C49]">{{ $header }}</h1>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-grow">
                <div class="py-6 px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
            
            <!-- Footer -->
            <footer class="bg-white py-4 border-t border-[#735C49]/20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-[#735C49]">
                    &copy; {{ date('Y') }} Hekkensluiter Beheer Systeem
                </div>
            </footer>
        </div>
    </body>
</html>