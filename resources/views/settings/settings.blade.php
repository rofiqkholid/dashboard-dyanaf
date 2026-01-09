<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-4 sm:mb-6">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-cog mr-2 text-gray-600"></i> General Settings
                    </h3>
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4 mb-4">
                            <div>
                                <label for="app_name" class="block text-sm font-medium text-gray-700 mb-2">Application Name</label>
                                <input type="text" name="app_name" id="app_name" value="Dyanaf Control Admin"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>
                            <div>
                                <label for="app_url" class="block text-sm font-medium text-gray-700 mb-2">Application URL</label>
                                <input type="url" name="app_url" id="app_url" value="{{ config('app.url') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>
                            <div>
                                <label for="app_description" class="block text-sm font-medium text-gray-700 mb-2">Application Description</label>
                                <textarea name="app_description" id="app_description" rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">Admin dashboard for Dyanaf Store</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition text-sm">
                                <i class="fas fa-save mr-2"></i> Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-4 sm:mb-6">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-bell mr-2 text-gray-600"></i> Notification Settings
                    </h3>
                    <div class="space-y-3">
                        <label class="flex items-center justify-between p-3 sm:p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1 mr-4">
                                <span class="text-sm font-medium text-gray-900">Email Notifications</span>
                                <p class="text-xs text-gray-500 mt-0.5">Receive email notifications for new orders</p>
                            </div>
                            <input type="checkbox" checked class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 flex-shrink-0">
                        </label>
                        <label class="flex items-center justify-between p-3 sm:p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1 mr-4">
                                <span class="text-sm font-medium text-gray-900">Order Alerts</span>
                                <p class="text-xs text-gray-500 mt-0.5">Get notified when a new order is placed</p>
                            </div>
                            <input type="checkbox" checked class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 flex-shrink-0">
                        </label>
                        <label class="flex items-center justify-between p-3 sm:p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1 mr-4">
                                <span class="text-sm font-medium text-gray-900">User Registration Alerts</span>
                                <p class="text-xs text-gray-500 mt-0.5">Get notified when a new user registers</p>
                            </div>
                            <input type="checkbox" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 flex-shrink-0">
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-info-circle mr-2 text-gray-600"></i> System Information
                    </h3>
                    <div class="grid grid-cols-2 gap-3 sm:gap-4">
                        <div class="p-3 sm:p-4 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-500 mb-1">Laravel Version</p>
                            <p class="text-sm font-medium text-gray-900">{{ app()->version() }}</p>
                        </div>
                        <div class="p-3 sm:p-4 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-500 mb-1">PHP Version</p>
                            <p class="text-sm font-medium text-gray-900">{{ phpversion() }}</p>
                        </div>
                        <div class="p-3 sm:p-4 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-500 mb-1">Environment</p>
                            <p class="text-sm font-medium text-gray-900">{{ config('app.env') }}</p>
                        </div>
                        <div class="p-3 sm:p-4 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-500 mb-1">Debug Mode</p>
                            <p class="text-sm font-medium text-gray-900">{{ config('app.debug') ? 'Enabled' : 'Disabled' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>