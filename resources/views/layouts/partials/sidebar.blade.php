@php
    // Helper function untuk nav link. Tetap sama dan berfungsi dengan baik.
    function navLink($routeName, $iconName, $label, $activeIconClass = 'text-blue-600', $inactiveIconClass = 'text-gray-400 group-hover:text-gray-500') {
        $active = request()->routeIs($routeName) || request()->routeIs($routeName . '.*');
        
        $linkClasses = $active 
            ? 'bg-blue-50 text-blue-600' 
            : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900';

        $iconClass = $active ? $activeIconClass : $inactiveIconClass;

        return '
            <a href="'.route($routeName).'" class="'.$linkClasses.' group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                '.Blade::render('@svg("'.$iconName.'", "h-6 w-6 shrink-0 '.$iconClass.'")').'
                '.$label.'
            </a>';
    }
@endphp

<div>
    {{-- MOBILE SIDEBAR --}}
    <div x-show="sidebarOpen" class="relative z-50 md:hidden" x-ref="dialog" aria-modal="true" x-cloak>
        {{-- Backdrop --}}
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80" @click="sidebarOpen = false"></div>
        <div class="fixed inset-0 flex">
            <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative mr-16 flex w-full max-w-xs flex-col">
                {{-- Tombol Close --}}
                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                    <button type="button" @click="sidebarOpen = false" class="-m-2.5 p-2.5">
                        <span class="sr-only">Close sidebar</span>
                        @svg('heroicon-o-x-mark', 'h-6 w-6 text-white')
                    </button>
                </div>
                {{-- Konten Sidebar Mobile --}}
                <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
                    <div class="flex h-16 shrink-0 items-center">
                        @svg('heroicon-o-cube-transparent', 'h-9 w-9 text-blue-600')
                        <span class="ml-3 self-center text-2xl font-bold whitespace-nowrap text-gray-800">Zenventory</span>
                    </div>
                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <ul role="list" class="-mx-2 space-y-1">
                                    <li>{!! navLink('dashboard', 'heroicon-o-home', 'Dashboard') !!}</li>
                                    {{-- Dropdown Master Data --}}
                                    <li x-data="{ open: {{ request()->routeIs(['products.*', 'locations.*']) ? 'true' : 'false' }} }">
                                        <div @click="open = !open" class="flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 cursor-pointer hover:bg-gray-50 hover:text-gray-900">
                                            @svg('heroicon-o-circle-stack', 'h-6 w-6 shrink-0 text-gray-400') Master Data
                                            <svg class="ml-auto h-5 w-5 shrink-0 transition-transform" :class="{'rotate-90': open}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <ul x-show="open" x-collapse class="mt-1 px-2">
                                            <li>{!! navLink('products.index', 'heroicon-o-tag', 'Products') !!}</li>
                                            <li>{!! navLink('locations.index', 'heroicon-o-map-pin', 'Locations') !!}</li>
                                        </ul>
                                    </li>
                                    {{-- Dropdown Inbound --}}
                                    <li x-data="{ open: {{ request()->routeIs('inbound.*') ? 'true' : 'false' }} }">
                                        <div @click="open = !open" class="flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 cursor-pointer hover:bg-gray-50 hover:text-gray-900">
                                            @svg('heroicon-o-arrow-down-tray', 'h-6 w-6 shrink-0 text-gray-400') Inbound
                                            <svg class="ml-auto h-5 w-5 shrink-0 transition-transform" :class="{'rotate-90': open}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <ul x-show="open" x-collapse class="mt-1 px-2">
                                            <li>{!! navLink('inbound.receive', 'heroicon-o-inbox-arrow-down', 'Receive Items') !!}</li>
                                            <li>{!! navLink('inbound.history', 'heroicon-o-clock', 'Inbound History') !!}</li>
                                        </ul>
                                    </li>
                                    {{-- Dropdown Outbound --}}
                                    <li x-data="{ open: {{ request()->routeIs(['orders.*', 'outbound.*', 'history.orders']) ? 'true' : 'false' }} }">
                                        <div @click="open = !open" class="flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 cursor-pointer hover:bg-gray-50 hover:text-gray-900">
                                            @svg('heroicon-o-arrow-up-tray', 'h-6 w-6 shrink-0 text-gray-400') Outbound
                                            <svg class="ml-auto h-5 w-5 shrink-0 transition-transform" :class="{'rotate-90': open}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <ul x-show="open" x-collapse class="mt-1 px-2">
                                            <li>{!! navLink('orders.index', 'heroicon-o-document-text', 'Sales Orders') !!}</li>
                                            <li>{!! navLink('outbound.allocation', 'heroicon-o-swatch', 'Allocate & Pick') !!}</li>
                                            <li>{!! navLink('history.orders', 'heroicon-o-bookmark-square', 'Order History') !!}</li>
                                        </ul>
                                    </li>
                                    {{-- Dropdown Inventory Control --}}
                                    <li x-data="{ open: {{ request()->routeIs('inventory.*') ? 'true' : 'false' }} }">
                                        <div @click="open = !open" class="flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 cursor-pointer hover:bg-gray-50 hover:text-gray-900">
                                            @svg('heroicon-o-clipboard-document-check', 'h-6 w-6 shrink-0 text-gray-400') Inventory Control
                                            <svg class="ml-auto h-5 w-5 shrink-0 transition-transform" :class="{'rotate-90': open}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <ul x-show="open" x-collapse class="mt-1 px-2">
                                            <li>{!! navLink('inventory.trace', 'heroicon-o-magnifying-glass', 'Trace LPN') !!}</li>
                                            <li>{!! navLink('inventory.stock', 'heroicon-o-table-cells', 'Stock Details') !!}</li>
                                            <li>{!! navLink('inventory.cycle-count', 'heroicon-o-calculator', 'Cycle Count') !!}</li>
                                            <li>{!! navLink('inventory.adjustment', 'heroicon-o-arrows-right-left', 'Stock Adjustment') !!}</li>
                                            <li>{!! navLink('inventory.returns', 'heroicon-o-arrow-uturn-left', 'Return Management') !!}</li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            {{-- Blok User Profile & Logout di bagian bawah untuk Mobile --}}
                            <li class="mt-auto">
                                <div class="border-t border-gray-200 -mx-6 px-6 pt-4">
                                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'bg-blue-50' : '' }} group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-gray-900">
                                        @svg('heroicon-o-user-circle', 'h-6 w-6 shrink-0 ' . (request()->routeIs('profile.edit') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500'))
                                        <span>{{ Auth::user()->name }}</span>
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-gray-900 w-full">
                                            @svg('heroicon-o-arrow-left-on-rectangle', 'h-6 w-6 shrink-0 text-gray-400 group-hover:text-gray-500')
                                            Log Out
                                        </button>
                                    </form>
                                </div>
                            </li>
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
                @svg('heroicon-o-cube-transparent', 'h-9 w-9 text-blue-600')
                <span class="ml-3 self-center text-2xl font-bold whitespace-nowrap text-gray-800">Zenventory</span>
            </div>
            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                        <ul role="list" class="-mx-2 space-y-1">
                            <li>{!! navLink('dashboard', 'heroicon-o-home', 'Dashboard') !!}</li>
                            {{-- Dropdown Master Data --}}
                            <li x-data="{ open: {{ request()->routeIs(['products.*', 'locations.*']) ? 'true' : 'false' }} }">
                                <div @click="open = !open" class="flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 cursor-pointer hover:bg-gray-50 hover:text-gray-900">
                                    @svg('heroicon-o-circle-stack', 'h-6 w-6 shrink-0 text-gray-400') Master Data
                                    <svg class="ml-auto h-5 w-5 shrink-0 transition-transform" :class="{'rotate-90': open}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path></svg>
                                </div>
                                <ul x-show="open" x-collapse class="mt-1 px-2">
                                    <li>{!! navLink('products.index', 'heroicon-o-tag', 'Products') !!}</li>
                                    <li>{!! navLink('locations.index', 'heroicon-o-map-pin', 'Locations') !!}</li>
                                </ul>
                            </li>
                             {{-- Dropdown Inbound --}}
                            <li x-data="{ open: {{ request()->routeIs('inbound.*') ? 'true' : 'false' }} }">
                                <div @click="open = !open" class="flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 cursor-pointer hover:bg-gray-50 hover:text-gray-900">
                                    @svg('heroicon-o-arrow-down-tray', 'h-6 w-6 shrink-0 text-gray-400') Inbound
                                    <svg class="ml-auto h-5 w-5 shrink-0 transition-transform" :class="{'rotate-90': open}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path></svg>
                                </div>
                                <ul x-show="open" x-collapse class="mt-1 px-2">
                                    <li>{!! navLink('inbound.receive', 'heroicon-o-inbox-arrow-down', 'Receive Items') !!}</li>
                                    <li>{!! navLink('inbound.history', 'heroicon-o-clock', 'Inbound History') !!}</li>
                                </ul>
                            </li>
                            {{-- Dropdown Outbound --}}
                            <li x-data="{ open: {{ request()->routeIs(['orders.*', 'outbound.*', 'history.orders']) ? 'true' : 'false' }} }">
                                <div @click="open = !open" class="flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 cursor-pointer hover:bg-gray-50 hover:text-gray-900">
                                    @svg('heroicon-o-arrow-up-tray', 'h-6 w-6 shrink-0 text-gray-400') Outbound
                                    <svg class="ml-auto h-5 w-5 shrink-0 transition-transform" :class="{'rotate-90': open}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path></svg>
                                </div>
                                <ul x-show="open" x-collapse class="mt-1 px-2">
                                    <li>{!! navLink('orders.index', 'heroicon-o-document-text', 'Sales Orders') !!}</li>
                                    <li>{!! navLink('outbound.allocation', 'heroicon-o-swatch', 'Allocate & Pick') !!}</li>
                                    <li>{!! navLink('history.orders', 'heroicon-o-bookmark-square', 'Order History') !!}</li>
                                </ul>
                            </li>
                            {{-- Dropdown Inventory Control --}}
                            <li x-data="{ open: {{ request()->routeIs('inventory.*') ? 'true' : 'false' }} }">
                                <div @click="open = !open" class="flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 cursor-pointer hover:bg-gray-50 hover:text-gray-900">
                                    @svg('heroicon-o-clipboard-document-check', 'h-6 w-6 shrink-0 text-gray-400') Inventory Control
                                    <svg class="ml-auto h-5 w-5 shrink-0 transition-transform" :class="{'rotate-90': open}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path></svg>
                                </div>
                                <ul x-show="open" x-collapse class="mt-1 px-2">
                                    <li>{!! navLink('inventory.trace', 'heroicon-o-magnifying-glass', 'Trace LPN') !!}</li>
                                    <li>{!! navLink('inventory.stock', 'heroicon-o-table-cells', 'Stock Details') !!}</li>
                                    <li>{!! navLink('inventory.cycle-count', 'heroicon-o-calculator', 'Cycle Count') !!}</li>
                                    <li>{!! navLink('inventory.adjustment', 'heroicon-o-arrows-right-left', 'Stock Adjustment') !!}</li>
                                    <li>{!! navLink('inventory.returns', 'heroicon-o-arrow-uturn-left', 'Return Management') !!}</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    {{-- Blok User Profile & Logout di bagian bawah untuk Desktop --}}
                    <li class="-mx-6 mt-auto">
                        <div class="flex items-center justify-between gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-gray-900 {{ request()->routeIs('profile.edit') ? 'bg-blue-50' : 'hover:bg-gray-50' }}">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-x-3 flex-grow">
                                @svg('heroicon-o-user-circle', 'h-8 w-8 ' . (request()->routeIs('profile.edit') ? 'text-blue-600' : 'text-gray-400'))
                                <div>
                                    <p class="text-sm font-semibold leading-6 text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs leading-5 text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" title="Log Out" class="text-gray-400 hover:text-red-500">
                                    @svg('heroicon-o-arrow-left-on-rectangle', 'h-6 w-6')
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>