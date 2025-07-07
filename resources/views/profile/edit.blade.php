<x-app-layout>
    <div class="space-y-6">
        {{-- Page Header --}}
        <div class="bg-white p-6 shadow-md rounded-lg">
            <x-page-header title="Profile & Account Settings">
                <p class="mt-1 text-sm text-gray-600">Manage your profile information, password, and account settings.</p>
            </x-page-header>
        </div>

        {{-- Main Content Card --}}
        <div class="bg-white p-8 rounded-xl shadow-lg">
            
            {{-- Section to update profile information --}}
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="border-t border-gray-200 my-10"></div>

            {{-- Section to update password --}}
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>

            <div class="border-t border-gray-200 my-10"></div>

            {{-- Section to delete account --}}
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>