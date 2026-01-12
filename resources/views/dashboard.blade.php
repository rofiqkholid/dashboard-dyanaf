<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-4 sm:mb-6">
                <!-- Total Users -->
                <div class="bg-white overflow-hidden border border-gray-200 rounded-lg">
                    <div class="p-3 sm:p-6">
                        <div class="flex items-center">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-users text-white text-sm sm:text-lg"></i>
                            </div>
                            <div class="ml-3 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Users</p>
                                <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ number_format($totalUsers) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Products -->
                <div class="bg-white overflow-hidden border border-gray-200 rounded-lg">
                    <div class="p-3 sm:p-6">
                        <div class="flex items-center">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-box text-white text-sm sm:text-lg"></i>
                            </div>
                            <div class="ml-3 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Products</p>
                                <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ number_format($totalProducts) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="bg-white overflow-hidden border border-gray-200 rounded-lg">
                    <div class="p-3 sm:p-6">
                        <div class="flex items-center">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-500 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-shopping-bag text-white text-sm sm:text-lg"></i>
                            </div>
                            <div class="ml-3 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Orders</p>
                                <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ number_format($totalOrders) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue -->
                <div class="bg-white overflow-hidden border border-gray-200 rounded-lg">
                    <div class="p-3 sm:p-6">
                        <div class="flex items-center">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-dollar-sign text-white text-sm sm:text-lg"></i>
                            </div>
                            <div class="ml-3 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Revenue</p>
                                <p class="text-lg sm:text-2xl font-semibold text-gray-900">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden border border-gray-200 rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-3 sm:grid-cols-5 gap-2 sm:gap-4">
                        <a href="{{ route('products.index') }}" class="flex flex-col items-center p-3 sm:p-4 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-box-open text-xl sm:text-2xl text-gray-600 mb-1 sm:mb-2"></i>
                            <span class="text-xs sm:text-sm text-gray-700 text-center">View Products</span>
                        </a>
                        <a href="{{ route('products.create') }}" class="flex flex-col items-center p-3 sm:p-4 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-plus-circle text-xl sm:text-2xl text-gray-600 mb-1 sm:mb-2"></i>
                            <span class="text-xs sm:text-sm text-gray-700 text-center">Add Product</span>
                        </a>
                        <a href="{{ route('orders.index') }}" class="flex flex-col items-center p-3 sm:p-4 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-clipboard-list text-xl sm:text-2xl text-gray-600 mb-1 sm:mb-2"></i>
                            <span class="text-xs sm:text-sm text-gray-700 text-center">View Orders</span>
                        </a>
                        <a href="{{ route('users.index') }}" class="flex flex-col items-center p-3 sm:p-4 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-users-cog text-xl sm:text-2xl text-gray-600 mb-1 sm:mb-2"></i>
                            <span class="text-xs sm:text-sm text-gray-700 text-center">Manage Users</span>
                        </a>
                        <a href="{{ route('settings.index') }}" class="flex flex-col items-center p-3 sm:p-4 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-cog text-xl sm:text-2xl text-gray-600 mb-1 sm:mb-2"></i>
                            <span class="text-xs sm:text-sm text-gray-700 text-center">Settings</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mt-4 sm:mt-6">
                <!-- Orders Chart -->
                <div class="bg-white overflow-hidden border border-gray-200 rounded-lg p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-4">Orders per Month</h3>
                    <div class="relative h-48 sm:h-64 w-full">
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>

                <!-- Revenue Chart -->
                <div class="bg-white overflow-hidden border border-gray-200 rounded-lg p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-4">Revenue per Month</h3>
                    <div class="relative h-48 sm:h-64 w-full">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden Data Container -->
        <div id="chart-data"
            data-months="{{ json_encode($months ?? []) }}"
            data-month-numbers="{{ json_encode($monthNumbers ?? []) }}"
            data-full-months="{{ json_encode($fullMonths ?? []) }}"
            data-orders="{{ json_encode($ordersData ?? []) }}"
            data-revenue="{{ json_encode($revenueData ?? []) }}"
            class="hidden">
        </div>

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Data from DOM attributes (Safe & IDE friendly)
                const dataEl = document.getElementById('chart-data');
                const months = JSON.parse(dataEl.dataset.months);
                const monthNumbers = JSON.parse(dataEl.dataset.monthNumbers);
                const fullMonths = JSON.parse(dataEl.dataset.fullMonths);
                const ordersData = JSON.parse(dataEl.dataset.orders);
                const revenueData = JSON.parse(dataEl.dataset.revenue);

                // Set Global Chart Font
                Chart.defaults.font.family = "'Outfit', sans-serif";

                // Handle Responsive Labels (Numbers on Mobile, Short Name on Desktop)
                const isMobile = window.innerWidth < 640;
                const chartLabels = isMobile ? monthNumbers : months;

                // Common Options Configuration
                const commonOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                title: function(context) {
                                    // Always show full month name in tooltip
                                    return fullMonths[context[0].dataIndex];
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            },
                            ticks: {
                                maxTicksLimit: 5
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                };

                // Orders Chart
                const ctxOrders = document.getElementById('ordersChart').getContext('2d');
                new Chart(ctxOrders, {
                    type: 'bar',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: 'Orders',
                            data: ordersData,
                            backgroundColor: '#3b82f6', // blue-500
                            borderRadius: 4,
                            hoverBackgroundColor: '#2563eb' // blue-600
                        }]
                    },
                    options: commonOptions
                });

                // Revenue Chart
                const ctxRevenue = document.getElementById('revenueChart').getContext('2d');

                // Clone common options and customize for Revenue
                const revenueOptions = JSON.parse(JSON.stringify(commonOptions));

                // Re-apply tooltip title callback (lost in JSON clone)
                revenueOptions.plugins.tooltip.callbacks.title = function(context) {
                    return fullMonths[context[0].dataIndex];
                };

                // Add revenue-specific tooltip label formatter
                revenueOptions.plugins.tooltip.callbacks.label = function(context) {
                    let label = context.dataset.label || '';
                    if (label) {
                        label += ': ';
                    }
                    if (context.parsed.y !== null) {
                        label += new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(context.parsed.y);
                    }
                    return label;
                };

                // Add Y-axis grid and K format for Revenue
                revenueOptions.scales.y.grid = {
                    color: '#f3f4f6'
                };
                revenueOptions.scales.y.ticks = {
                    maxTicksLimit: 5,
                    callback: function(value) {
                        return (value / 1000).toFixed(0) + 'K';
                    }
                };

                new Chart(ctxRevenue, {
                    type: 'line',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: 'Revenue',
                            data: revenueData,
                            borderColor: '#22c55e', // green-500
                            backgroundColor: 'rgba(34, 197, 94, 0.1)',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.4,
                            pointBackgroundColor: '#22c55e'
                        }]
                    },
                    options: revenueOptions
                });
            });
        </script>
</x-app-layout>