<aside class="w-72 flex-shrink-0 bg-white text-gray-600 p-4 flex flex-col rounded-lg shadow-md">
    <div class="flex items-center space-x-3 rtl:space-x-reverse mb-8 px-4 py-2">
        <svg class="w-9 h-9 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
        </svg>
        <span class="self-center text-2xl font-bold whitespace-nowrap text-gray-800">Zenventory</span>
    </div>

    <nav class="flex-grow">
        <ul class="space-y-2">
            @php
            function navLink($routeName, $icon, $label) {
                $activeClasses = 'bg-blue-50 text-blue-600 font-semibold';
                $inactiveClasses = 'text-gray-600 hover:bg-gray-100 hover:text-gray-900';
                $classes = request()->routeIs($routeName) ? $activeClasses : $inactiveClasses;

                return '<a href="'.route($routeName).'" class="flex items-center p-3 rounded-lg transition duration-150 '.$classes.'">'.$icon.'<span class="ml-3">'.$label.'</span></a>';
            }
            @endphp

            <li>{!! navLink('dashboard', '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>', 'Dashboard') !!}</li>
            <li>{!! navLink('products.index', '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 8v5z"></path></svg>', 'Products') !!}</li>
            <li>{!! navLink('locations.index', '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>', 'Locations') !!}</li>
            </ul>
    </nav>
</aside>