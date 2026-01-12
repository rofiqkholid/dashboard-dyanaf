<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Products') }}
            </h2>
            <div class="flex gap-3">
                <!-- Search only visible on desktop -->
                <div class="relative hidden sm:block">
                    <input type="text"
                        id="search-input-desktop"
                        value="{{ request('search') }}"
                        placeholder="Search products..."
                        class="w-64 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm pl-10">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
                <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i> Add Product
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
                {{ session('success') }}
            </div>
            @endif

            <!-- Content for AJAX Replacement -->
            <div id="products-content">

                <!-- Mobile Search (inside content area) -->
                <div class="sm:hidden mb-3">
                    <div class="relative">
                        <input type="text"
                            id="search-input-mobile"
                            value="{{ request('search') }}"
                            placeholder="Search products..."
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm pl-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Mobile Card View -->
                <div class="sm:hidden space-y-3">
                    @forelse($products as $product)
                    <div class="bg-white rounded-lg border border-gray-200 p-3">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    @if($product->icon)
                                    <i class="{{ $product->icon }} text-lg text-gray-600"></i>
                                    @else
                                    <i class="fas fa-box text-lg text-gray-400"></i>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $product->slug }}</div>
                                </div>
                            </div>
                            @if($product->is_active)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                            @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Inactive
                            </span>
                            @endif
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs mb-3">
                            <div class="bg-gray-50 rounded p-2">
                                <span class="text-gray-500">Price</span>
                                <p class="font-medium text-gray-900">{{ $product->price_display ?? 'Rp ' . number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-gray-50 rounded p-2">
                                <span class="text-gray-500">Estimation</span>
                                <p class="font-medium text-gray-900">{{ $product->estimation ?? '-' }}</p>
                            </div>
                        </div>
                        @if($product->tag)
                        <div class="mb-3">
                            <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">{{ $product->tag }}</span>
                        </div>
                        @endif
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-500">Order: {{ $product->order }}</span>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:text-blue-800 p-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form id="delete-product-{{ $product->id }}" action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-600 hover:text-red-800 p-2"
                                        onclick="openConfirmModal({
                                        title: 'Delete Product',
                                        message: 'Are you sure you want to delete {{ $product->name }}?',
                                        confirmText: 'Delete',
                                        onConfirm: () => document.getElementById('delete-product-{{ $product->id }}').submit()
                                    })">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white rounded-lg border border-gray-200 p-6 text-center text-gray-500">
                        <i class="fas fa-inbox text-3xl text-gray-300 mb-2"></i>
                        <p class="text-sm">No products found</p>
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
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Icon</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tag</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estimation</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($products as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->order }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                                @if($product->icon)
                                                <i class="{{ $product->icon }} text-xl text-gray-600"></i>
                                                @else
                                                <i class="fas fa-box text-xl text-gray-400"></i>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $product->slug }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $product->tag ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $product->price_display ?? 'Rp ' . number_format($product->price, 0, ',', '.') }}</div>
                                            @if($product->price_unit)
                                            <div class="text-xs text-gray-500">{{ $product->price_unit }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->estimation ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($product->is_active)
                                            <span class="px-3 py-1 inline-flex items-center gap-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle"></i>
                                                <span>Active</span>
                                            </span>
                                            @else
                                            <span class="px-3 py-1 inline-flex items-center gap-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                <i class="fas fa-times-circle"></i>
                                                <span>Inactive</span>
                                            </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:text-blue-800">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form id="delete-product-desktop-{{ $product->id }}" action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="text-red-600 hover:text-red-800"
                                                        onclick="openConfirmModal({
                                                        title: 'Delete Product',
                                                        message: 'Are you sure you want to delete {{ $product->name }}?',
                                                        confirmText: 'Delete',
                                                        onConfirm: () => document.getElementById('delete-product-desktop-{{ $product->id }}').submit()
                                                    })">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                            <i class="fas fa-inbox text-4xl text-gray-400 mb-3"></i>
                                            <p class="mt-2">No products found</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let searchTimeout;
        const searchInputDesktop = document.getElementById('search-input-desktop');
        const searchInputMobile = document.getElementById('search-input-mobile');
        const contentDiv = document.getElementById('products-content');

        function handleSearch(query) {
            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(() => {
                const url = new URL(window.location.href);
                if (query) {
                    url.searchParams.set('search', query);
                } else {
                    url.searchParams.delete('search');
                }
                window.history.pushState({}, '', url);

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
                        const newContent = doc.getElementById('products-content');
                        if (newContent) {
                            contentDiv.innerHTML = newContent.innerHTML;
                        }
                    })
                    .catch(error => console.error('Error:', error))
                    .finally(() => {
                        if (typeof NProgress !== 'undefined') NProgress.done();
                    });
            }, 500);
        }

        function syncInputs(source, target) {
            if (target) target.value = source.value;
        }

        if (searchInputDesktop) {
            searchInputDesktop.addEventListener('input', function() {
                handleSearch(this.value);
                syncInputs(this, searchInputMobile);
            });
        }

        if (searchInputMobile) {
            searchInputMobile.addEventListener('input', function() {
                handleSearch(this.value);
                syncInputs(this, searchInputDesktop);
            });
        }
    </script>
</x-app-layout>