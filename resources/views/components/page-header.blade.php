@props(['title'])

<div class="flex flex-col md:flex-row md:justify-between md:items-center">
    {{-- Judul Halaman --}}
    <h1 class="text-2xl font-semibold text-gray-900 mb-4 md:mb-0">
        {{ $title }}
    </h1>
    
    {{-- Kontrol (Search dan Tombol) --}}
    <div class="flex items-center space-x-4">
        {{-- Slot ini akan diisi oleh input search dan tombol dari view pemanggil --}}
        {{ $slot }}
    </div>
</div>