<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100">
    
    <div class="min-h-screen flex p-4 space-x-4">
        @include('layouts.partials.sidebar')

        <div class="flex-1 flex flex-col space-y-4">
            @if (isset($header))
                <header class="bg-white rounded-lg shadow-md p-6">
                    {{ $header }}
                </header>
            @endif

            <main class="flex-1 bg-white rounded-lg shadow-md p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('modals')
    @livewireScripts
</html>