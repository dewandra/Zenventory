<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700&display=swap" rel="stylesheet" />

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased">
    
    <div x-data="{ sidebarOpen: false }" @keydown.window.escape="sidebarOpen = false">
        
        @include('layouts.partials.sidebar')

        <div class="md:pl-72">
            <div class="mx-auto flex max-w-7xl flex-col md:px-8 xl:px-0">
                
                <div class="sticky top-0 z-10 flex h-16 shrink-0 items-center gap-x-6 border-b border-gray-200 bg-white px-4 shadow-sm sm:px-6 md:hidden">
                    <button type="button" @click="sidebarOpen = true" class="-m-2.5 p-2.5 text-gray-700">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                    <div class="flex-1 text-lg font-semibold leading-6 text-gray-900">Zenventory</div>
                </div>

                <main class="flex-1 p-4 md:p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>

    @stack('modals')
    @livewireScripts
</body>
</html>