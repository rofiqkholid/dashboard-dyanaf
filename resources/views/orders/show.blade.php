<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 sm:gap-3">
            <a href="{{ route('orders.index') }}" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition flex-shrink-0">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="min-w-0">
                <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">{{ __('Order Details') }}</h2>
                <p class="text-xs sm:text-sm text-gray-500 truncate">#{{ $order->order_id }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-4 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 sm:space-y-6">

            <!-- Basic Order Info -->
            <div class="bg-white overflow-hidden border border-gray-200 rounded-lg">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-shopping-bag text-yellow-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-semibold text-gray-900">{{ __('Basic Information') }}</h3>
                            <p class="text-xs text-gray-500">Order details and customer info</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        <div class="bg-gray-50 rounded-lg p-3">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Order ID</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $order->order_id }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Customer</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $order->customer_name }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Created At</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CV Order Details -->
            @if($order->cvOrder)
            <div class="bg-white overflow-hidden border border-gray-200 rounded-lg">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-file-alt text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-semibold text-gray-900">{{ __('CV Order Details') }}</h3>
                            <p class="text-xs text-gray-500">{{ __('Details from CV Order table') }}</p>
                        </div>
                    </div>

                    @php
                    $cvAttributes = collect($order->cvOrder->getAttributes())
                    ->except(['created_at', 'updated_at', 'id', 'laravel_through_key']);

                    // Helper to format value
                    $formatValue = function($value) {
                    if (empty($value)) return '-';

                    // Check if it looks like a JSON array with escaped quotes
                    if (preg_match('/^\[.*\]$/', $value) || strpos($value, '\"') !== false) {
                    // Remove escaped quotes
                    $clean = str_replace(['\"', '\\"'], '"', $value);
                    // Remove outer quotes if present
                    $clean = trim($clean, '"');

                    $decoded = json_decode($clean, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    return implode(', ', $decoded);
                    }
                    }

                    return $value;
                    };
                    @endphp

                    <!-- Mobile Card View -->
                    <div class="sm:hidden space-y-2">
                        @foreach($cvAttributes as $key => $value)
                        <div class="bg-gray-50 rounded-sm p-3">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">{{ str_replace('_', ' ', $key) }}</p>
                            <p class="text-sm text-gray-900 break-words">{{ $formatValue($value) }}</p>
                        </div>
                        @endforeach
                    </div>

                    <!-- Desktop Table View -->
                    <div class="hidden sm:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden">
                            <thead class="bg-gray-50">
                                <tr>
                                    @foreach($cvAttributes as $key => $value)
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ str_replace('_', ' ', $key) }}
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr class="hover:bg-gray-50">
                                    @foreach($cvAttributes as $key => $value)
                                    <td class="px-4 py-4 text-sm text-gray-900">
                                        {{ $formatValue($value) }}
                                    </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>