<x-app-layout>
    <div class="space-y-6">
        {{-- Header Halaman --}}
        <div class="bg-white p-6 shadow-md rounded-lg">
            <x-page-header title="Pengaturan Profil & Akun">
                <p class="mt-1 text-sm text-gray-600">Kelola informasi profil, kata sandi, dan pengaturan akun Anda.</p>
            </x-page-header>
        </div>

        {{-- Konten Utama dalam Satu Kartu --}}
        <div class="bg-white p-8 rounded-xl shadow-lg">
            
            {{-- Bagian untuk update informasi profil --}}
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="border-t border-gray-200 my-10"></div>

            {{-- Bagian untuk update password --}}
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>

            <div class="border-t border-gray-200 my-10"></div>

            {{-- Bagian untuk hapus akun --}}
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>