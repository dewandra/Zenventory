<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Login - Zenventory</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full font-sans antialiased bg-gray-100">
        <div class="min-h-full flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-md space-y-6">
                
                {{-- Logo dan Judul yang Diperbarui --}}
                <div class="mx-auto text-center">
                    <div class="flex items-center justify-center space-x-3">
                        @svg('heroicon-o-cube-transparent', 'h-10 w-10 text-blue-600')
                        <span class="text-4xl font-bold text-gray-800 font-inter">Zenventory</span>
                    </div>
                    <h2 class="mt-4 text-center text-2xl font-semibold tracking-tight text-gray-800">
                        Welcome Back!
                    </h2>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        Please sign in to continue to your dashboard.
                    </p>
                </div>

                {{-- Kartu Form --}}
                <div class="bg-white py-8 px-4 shadow-xl sm:rounded-lg sm:px-10">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>