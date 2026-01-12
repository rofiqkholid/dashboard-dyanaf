<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Orders') }}
            </h2>
            <div class="relative">
                <input type="text"
                    id="search-input"
                    value="{{ request('search') }}"
                    placeholder="Search orders..."
                    class="w-full sm:w-64 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm pl-10">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-4 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Content for AJAX Replacement -->
            <div id="orders-content">
                <!-- Mobile Card View -->
                <div class="sm:hidden space-y-3">
                    @forelse($orders as $order)
                    <div class="bg-white rounded-lg border border-gray-200 p-3">
                        <!-- Card Header -->
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-shopping-bag text-yellow-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">#{{ $order->order_id }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->customer_name }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                            <div class="flex items-center gap-1 text-gray-400">
                                <i class="fas fa-clock text-xs"></i>
                                <span class="text-xs">{{ $order->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-md bg-blue-50 text-blue-600 hover:bg-blue-100 transition">
                                <i class="fas fa-eye mr-1"></i> View
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white rounded-lg border border-gray-200 p-6 text-center">
                        <i class="fas fa-inbox text-3xl text-gray-300 mb-2"></i>
                        <p class="text-sm text-gray-500">No orders found</p>
                    </div>
                    @endforelse
                </div>

                <!-- Desktop Table View -->
                <div class="hidden sm:block bg-white overflow-hidden border border-gray-200 rounded-lg">
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Order ID
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Customer Name
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($orders as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-shopping-bag text-yellow-600 text-sm"></i>
                                                </div>
                                                <span class="ml-3 text-sm font-medium text-gray-900">{{ $order->order_id }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $order->customer_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $order->created_at->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition">
                                                <i class="fas fa-eye mr-1.5"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                            <i class="fas fa-inbox text-4xl text-gray-400 mb-3"></i>
                                            <p class="mt-2">No orders found</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        let searchTimeout;
        const searchInput = document.getElementById('search-input');
        const contentDiv = document.getElementById('orders-content');

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value;

            searchTimeout = setTimeout(() => {
                // Update URL without reloading
                const url = new URL(window.location.href);
                if (query) {
                    url.searchParams.set('search', query);
                } else {
                    url.searchParams.delete('search');
                }
                window.history.pushState({}, '', url);

                // Fetch new content
                if (typeof NProgress !== 'undefined') NProgress.start();
                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newContent = doc.getElementById('orders-content');
                        if (newContent) {
                            contentDiv.innerHTML = newContent.innerHTML;
                        }
                    })
                    .catch(error => console.error('Error:', error))
                    .finally(() => {
                        if (typeof NProgress !== 'undefined') NProgress.done();
                    });
            }, 500); // Debounce 500ms
        });
    </script>
</x-app-layout>