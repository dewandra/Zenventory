<div>
    {{-- MOBILE SIDEBAR --}}
    <div x-show="sidebarOpen" class="relative z-50 md:hidden" x-ref="dialog" aria-modal="true" x-cloak>
        {{-- Backdrop --}}
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80" @click="sidebarOpen = false"></div>

        <div class="fixed inset-0 flex">
            <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative mr-16 flex w-full max-w-xs flex-col">
                {{-- Tombol Close --}}
                <div class="absolute left-full top-0 flex w-16 justify-center pt-5"><button type="button" @click="sidebarOpen = false" class="-m-2.5 p-2.5"><span class="sr-only">Close sidebar</span><svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button></div>
                
                {{-- Konten Sidebar Mobile --}}
                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
                    <div class="flex h-16 shrink-0 items-center">
                        <svg class="h-9 w-9 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" /></svg>
                        <span class="ml-3 self-center text-2xl font-bold whitespace-nowrap text-gray-800">Zenventory</span>
                    </div>
                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <ul role="list" class="-mx-2 space-y-1">
                                    @php
                                    // Helper function for mobile links (disederhanakan)
                                    function navLinkMobile($routeName, $icon, $label) {
                                        $active = request()->routeIs($routeName) || request()->routeIs($routeName . '.*');
                                        $activeClasses = 'bg-blue-50 text-blue-600';
                                        $inactiveClasses = 'text-gray-700 hover:bg-gray-50 hover:text-gray-900';
                                        return '<a href="'.route($routeName).'" class="'. ($active ? $activeClasses : $inactiveClasses) .' group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">'.$icon.$label.'</a>';
                                    }
                                    @endphp

                                    {{-- KODE MOBILE YANG DIPERBAIKI TOTAL --}}
                                    <li>{!! navLinkMobile('dashboard', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path></svg>', 'Dashboard') !!}</li>
                                    <li>{!! navLinkMobile('products.index', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"></path></svg>', 'Products') !!}</li>
                                    <li>{!! navLinkMobile('locations.index', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"></path></svg>', 'Locations') !!}</li>
                                    <li>{!! navLinkMobile('inbound.receive', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>', 'Receive Items') !!}</li>
                                    <li>{!! navLinkMobile('inbound.history', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>', 'Inbound History') !!}</li>
                                    <li>{!! navLinkMobile('orders.index', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>', 'Sales Orders') !!}</li>
                                    <li>{!! navLinkMobile('outbound.allocation', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z"></path></svg>', 'Allocate & Pick') !!}</li>
                                    <li>{!! navLinkMobile('inventory.trace', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>', 'Lacak LPN') !!}</li>
                                    <li>{!! navLinkMobile('inventory.stock', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4M4 7l8 4 8-4M4 12l8 4 8-4"></path></svg>', 'Detail Stok') !!}</li>
                                    <li>{!! navLinkMobile('inventory.cycle-count', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h3m-3-10h.01M9 3h6a2 2 0 012 2v14a2 2 0 01-2 2H9a2 2 0 01-2-2V5a2 2 0 012-2z"></path></svg>', 'Cycle Count') !!}</li>
                                    <li>{!! navLinkMobile('inventory.adjustment', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 16v-2m0-10v2M12 10a2 2 0 110-4 2 2 0 010 4zm0 10a2 2 0 110-4 2 2 0 010 4zM4 6h16M4 12h16M4 18h16"></path></svg>', 'Penyesuaian Stok') !!}</li>
                                    <li>{!! navLinkMobile('inventory.returns', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 15v-1a4 4 0 00-4-4H8m0 0l-3 3m3-3l3-3m-3 3h6a4 4 0 014 4v1m-4-10h-2a2 2 0 00-2 2v2h4V7a2 2 0 00-2-2z"></path></svg>', 'Manajemen Retur') !!}</li>
                                </ul>
                            </li>
                            <li class="mt-auto"><div class="border-t border-gray-200 -mx-6 px-6 pt-4"><a href="{{ route('profile.edit') }}" class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-gray-900"><svg class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>{{ Auth::user()->name }}</a><form method="POST" action="{{ route('logout') }}"><button type="submit" class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-gray-900 w-full">@csrf<svg class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"></path></svg>Log Out</button></form></div></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- DESKTOP SIDEBAR --}}
    <div class="hidden md:fixed md:inset-y-0 md:z-50 md:flex md:w-72 md:flex-col">
        <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6">
            <div class="flex h-16 shrink-0 items-center">
                <svg class="h-9 w-9 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" /></svg>
                <span class="ml-3 self-center text-2xl font-bold whitespace-nowrap text-gray-800">Zenventory</span>
            </div>
            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                        <ul role="list" class="-mx-2 space-y-1" x-data="{}">
                            @php
                            function navLink($routeName, $icon, $label) {
                                $active = request()->routeIs($routeName) || request()->routeIs($routeName . '.*');
                                $activeClasses = 'bg-blue-50 text-blue-600';
                                $inactiveClasses = 'text-gray-700 hover:bg-gray-50 hover:text-gray-900';
                                return '<a href="'.route($routeName).'" class="'. ($active ? $activeClasses : $inactiveClasses) .' group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">'.$icon.$label.'</a>';
                            }
                            @endphp

                            <li>{!! navLink('dashboard', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path></svg>', 'Dashboard') !!}</li>

                            {{-- Dropdown Master Data --}}
                            <li x-data="{ open: {{ request()->routeIs(['products.*', 'locations.*']) ? 'true' : 'false' }} }">
                                <div @click="open = !open" class="flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 cursor-pointer hover:bg-gray-50 hover:text-gray-900">
                                    <svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375"></path></svg>
                                    Master Data
                                    <svg class="ml-auto h-5 w-5 shrink-0 transition-transform" :class="{'rotate-90': open}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path></svg>
                                </div>
                                <ul x-show="open" x-collapse class="mt-1 px-2">
                                    <li>{!! navLink('products.index', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"></path></svg>', 'Products') !!}</li>
                                    <li>{!! navLink('locations.index', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"></path></svg>', 'Locations') !!}</li>
                                </ul>
                            </li>
                            
                            {{-- Dropdown Inbound --}}
                            <li x-data="{ open: {{ request()->routeIs('inbound.*') ? 'true' : 'false' }} }">
                                <div @click="open = !open" class="flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 cursor-pointer hover:bg-gray-50 hover:text-gray-900">
                                    <svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75v6.75m0 0l-3-3m3 3l3-3m-8.25 6a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"></path></svg>
                                    Inbound
                                    <svg class="ml-auto h-5 w-5 shrink-0 transition-transform" :class="{'rotate-90': open}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path></svg>
                                </div>
                                <ul x-show="open" x-collapse class="mt-1 px-2">
                                    <li>{!! navLink('inbound.receive', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>', 'Receive Items') !!}</li>
                                    <li>{!! navLink('inbound.history', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>', 'Inbound History') !!}</li>
                                </ul>
                            </li>
                            
                            {{-- Dropdown Outbound --}}
                            <li x-data="{ open: {{ request()->routeIs('orders.*') || request()->routeIs('outbound.*') ? 'true' : 'false' }} }">
                                <div @click="open = !open" class="flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 cursor-pointer hover:bg-gray-50 hover:text-gray-900">
                                    <svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"></path></svg>
                                    Outbound
                                    <svg class="ml-auto h-5 w-5 shrink-0 transition-transform" :class="{'rotate-90': open}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path></svg>
                                </div>
                                <ul x-show="open" x-collapse class="mt-1 px-2">
                                    <li>{!! navLink('orders.index', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>', 'Sales Orders') !!}</li>
                                    <li>{!! navLink('outbound.allocation', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z"></path></svg>', 'Allocate & Pick') !!}</li>
                                </ul>
                            </li>
                            
                            {{-- Dropdown Inventory Control --}}
                            <li x-data="{ open: {{ request()->routeIs('inventory.*') ? 'true' : 'false' }} }">
                                <div @click="open = !open" class="flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 cursor-pointer hover:bg-gray-50 hover:text-gray-900">
                                    <svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h12A2.25 2.25 0 0020.25 14.25V5.25A2.25 2.25 0 0018 3H6.75A2.25 2.25 0 003.75 3zM3.75 14.25v4.5A2.25 2.25 0 006 21h12a2.25 2.25 0 002.25-2.25v-4.5m-16.5 0a2.25 2.25 0 012.25-2.25h12a2.25 2.25 0 012.25 2.25m-16.5 0h16.5"></path></svg>
                                    Inventory Control
                                    <svg class="ml-auto h-5 w-5 shrink-0 transition-transform" :class="{'rotate-90': open}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path></svg>
                                </div>
                                <ul x-show="open" x-collapse class="mt-1 px-2">
                                    <li>{!! navLink('inventory.trace', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>', 'Lacak LPN') !!}</li>
                                    <li>{!! navLink('inventory.stock', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4M4 7l8 4 8-4M4 12l8 4 8-4"></path></svg>', 'Detail Stok') !!}</li>
                                    <li>{!! navLink('inventory.cycle-count', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h3m-3-10h.01M9 3h6a2 2 0 012 2v14a2 2 0 01-2 2H9a2 2 0 01-2-2V5a2 2 0 012-2z"></path></svg>', 'Cycle Count') !!}</li>
                                    <li>{!! navLink('inventory.adjustment', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 16v-2m0-10v2M12 10a2 2 0 110-4 2 2 0 010 4zm0 10a2 2 0 110-4 2 2 0 010 4zM4 6h16M4 12h16M4 18h16"></path></svg>', 'Penyesuaian Stok') !!}</li>
                                    <li>{!! navLink('inventory.returns', '<svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 15v-1a4 4 0 00-4-4H8m0 0l-3 3m3-3l3-3m-3 3h6a4 4 0 014 4v1m-4-10h-2a2 2 0 00-2 2v2h4V7a2 2 0 00-2-2z"></path></svg>', 'Manajemen Retur') !!}</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="-mx-6 mt-auto">
                        <div class="flex items-center gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-50">
                            <a href="{{ route('profile.edit') }}" class="flex-grow">
                                <p class="text-sm font-semibold leading-6 text-gray-900" aria-hidden="true">{{ Auth::user()->name }}</p>
                                <p class="text-xs leading-5 text-gray-500">{{ Auth::user()->email }}</p>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" title="Log Out" class="text-gray-400 hover:text-red-500">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>