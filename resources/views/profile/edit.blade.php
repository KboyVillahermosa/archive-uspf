<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-light text-[#26225C] mb-2">Profile Settings</h1>
                <p class="text-gray-600">Manage your account information and preferences</p>
            </div>

            <div class="space-y-6">
                <!-- Profile Information Card -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-6">
                        <div class="max-w-2xl">
                    @include('profile.partials.update-profile-information-form')
                        </div>
                </div>
            </div>

                <!-- Update Password Card -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-6">
                        <div class="max-w-2xl">
                    @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
