<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Login - Zenventory</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Inter:400,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex bg-white">
            
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12">
                <div class="mx-auto w-full max-w-md">
                    <div class="flex items-center space-x-3 rtl:space-x-reverse mb-4">
                        <svg class="w-10 h-10 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                        </svg>
                        <span class="self-center text-4xl font-bold whitespace-nowrap text-gray-800 font-inter">Zenventory</span>
                    </div>
                    <p class="text-gray-600 mb-8 text-lg font-inter">
                        Control your warehouse, achieve zen.
                    </p>
                    {{ $slot }}
                </div>
            </div>

            <div class="hidden lg:flex w-1/2 items-center justify-center relative bg-login-bg bg-cover bg-center">
                <div class="absolute inset-0 bg-gray-900 opacity-60"></div>
                <div class="relative text-center px-12 z-10">
                    <h2 class="text-4xl font-bold text-white leading-tight font-inter">
                        Precision & Efficiency in Every Shelf.
                    </h2>
                    <p class="mt-4 text-xl text-gray-200 font-inter">
                        The ultimate Warehouse Management System designed for clarity and growth.
                    </p>
                </div>
            </div>

        </div>
    </body>
</html>