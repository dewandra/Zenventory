<div><div 
        x-show="sidebarOpen" 
        class="relative z-50 md:hidden" 
        x-ref="dialog" 
        aria-modal="true"
        x-cloak
    >
        {{-- Latar belakang gelap transparan --}}
        <div 
            x-show="sidebarOpen" 
            x-transition:enter="transition-opacity ease-linear duration-300" 
            x-transition:enter-start="opacity-0" 
            x-transition:enter-end="opacity-100" 
            x-transition:leave="transition-opacity ease-linear duration-300" 
            x-transition:leave-start="opacity-100" 
            x-transition:leave-end="opacity-0" 
            class="fixed inset-0 bg-gray-900/80"
            @click="sidebarOpen = false"
        ></div>

        <div class="fixed inset-0 flex">
            <div 
                x-show="sidebarOpen"
                x-transition:enter="transition ease-in-out duration-300 transform" 
                x-transition:enter-start="-translate-x-full" 
                x-transition:enter-end="translate-x-0" 
                x-transition:leave="transition ease-in-out duration-300 transform" 
                x-transition:leave-start="translate-x-0" 
                x-transition:leave-end="-translate-x-full" 
                class="relative flex w-full max-w-sm flex-col bg-white"
            >
                <div class="absolute right-0 top-0 -mr-12 pt-2">
                    <button 
                        type="button" 
                        @click="sidebarOpen = false"
                        class="relative flex h-10 w-10 items-center justify-center rounded-full text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                    >
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Close sidebar</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="flex h-full flex-col overflow-y-auto bg-white py-6 shadow-xl">
                    <div class="px-4 sm:px-6">
                        <div class="flex items-center space-x-3">
                            <svg class="h-9 w-9 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                            </svg>
                            <span class="self-center text-2xl font-bold whitespace-nowrap text-gray-800">Zenventory</span>
                        </div>
                    </div>
                    <nav class="relative mt-6 flex-1 px-4 sm:px-6">
                        <ul role="list" class="-mx-2 space-y-1">
                            @php
                            if (!function_exists('navLinkMobile')) {
                                function navLinkMobile($routeName, $icon, $label) {
                                    $activeClasses = 'bg-blue-100 text-blue-600 font-semibold';
                                    $inactiveClasses = 'text-gray-600 hover:bg-gray-100 hover:text-gray-900';
                                    $classes = request()->routeIs($routeName) ? $activeClasses : $inactiveClasses;
                                    return '<a href="'.route($routeName).'" class="group flex gap-x-3 rounded-md p-2 text-base leading-6 font-medium '.$classes.'">'.$icon.$label.'</a>';
                                }
                            }
                            @endphp

                            <li>{!! navLinkMobile('dashboard', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>', 'Dashboard') !!}</li>
                            <li>{!! navLinkMobile('products.index', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 8v5z"></path></svg>', 'Products') !!}</li>
                            <li>{!! navLinkMobile('locations.index', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>', 'Locations') !!}</li>
                            <li>{!! navLinkMobile('inbound.receive', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>', 'Receive Items') !!}</li>
                            <li>{!! navLinkMobile('inbound.history', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>', 'Inbound History') !!}</li>
                            <li>{!! navLinkMobile('outbound.allocation', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z"></path></svg>', 'Allocate & Pick') !!}</li>
                            <li>{!! navLinkMobile('orders.index', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>', 'Sales Orders') !!}</li>
                            <li>{!! navLinkMobile('inventory.trace', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>', 'Lacak LPN') !!}</li>
                            <li>{!! navLinkMobile('inventory.stock', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4M4 7l8 4 8-4M4 12l8 4 8-4"></path></svg>', 'Detail Stok') !!}</li>
                            <li>{!! navLinkMobile('inventory.adjustment', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 16v-2m0-10v2M12 10a2 2 0 110-4 2 2 0 010 4zm0 10a2 2 0 110-4 2 2 0 010 4zM4 6h16M4 12h16M4 18h16"></path></svg>', 'Penyesuaian Stok') !!}</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- DESKTOP SIDEBAR --}}
    <div class="hidden md:fixed md:inset-y-4 md:left-4 md:z-50 md:flex md:w-72 md:flex-col">
        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 py-4 rounded-xl shadow-lg">
            <div class="flex h-16 shrink-0 items-center space-x-3">
                <svg class="h-9 w-9 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                </svg>
                <span class="self-center text-2xl font-bold whitespace-nowrap text-gray-800">Zenventory</span>
            </div>
            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                        <ul role="list" class="-mx-2 space-y-1">
                            @php
                            if (!function_exists('navLink')) {
                                function navLink($routeName, $icon, $label) {
                                    $activeClasses = 'bg-blue-100 text-blue-600 font-semibold';
                                    $inactiveClasses = 'text-gray-600 hover:bg-gray-100 hover:text-gray-900';
                                    $classes = request()->routeIs($routeName) ? $activeClasses : $inactiveClasses;
                                    return '<a href="'.route($routeName).'" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-medium '.$classes.'">'.$icon.$label.'</a>';
                                }
                            }
                            @endphp

                            <li>{!! navLink('dashboard', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>', 'Dashboard') !!}</li>
                            <li>{!! navLink('products.index', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 8v5z"></path></svg>', 'Products') !!}</li>
                            <li>{!! navLink('locations.index', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>', 'Locations') !!}</li>
                            <li>{!! navLink('inbound.receive', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>', 'Receive Items') !!}</li>
                            <li>{!! navLink('inbound.history', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>', 'Inbound History') !!}</li>
                            <li>{!! navLink('outbound.allocation', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z"></path></svg>', 'Allocate & Pick') !!}</li>
                            <li>{!! navLink('orders.index', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>', 'Sales Orders') !!}</li>
                            <li>{!! navLink('inventory.trace', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>', 'Lacak LPN') !!}</li>
                            <li>{!! navLink('inventory.stock', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4M4 7l8 4 8-4M4 12l8 4 8-4"></path></svg>', 'Detail Stok') !!}</li>
                            <li>{!! navLink('inventory.adjustment', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 16v-2m0-10v2M12 10a2 2 0 110-4 2 2 0 010 4zm0 10a2 2 0 110-4 2 2 0 010 4zM4 6h16M4 12h16M4 18h16"></path></svg>', 'Penyesuaian Stok') !!}</li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>