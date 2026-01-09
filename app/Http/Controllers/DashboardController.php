<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Users (non-admin)
        $totalUsers = User::where('is_admin', 0)->count();

        // Total Products (active services)
        $totalProducts = Service::where('is_active', 1)->count();

        // Total Orders (transactions count)
        $totalOrders = Transaction::count();

        // Revenue (sum of amount)
        // Revenue (sum of amount)
        $revenue = Transaction::sum('amount');

        // Chart Data: Current Year
        $currentYear = now()->year;
        $chartData = Transaction::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(amount) as total_amount')
        )
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare arrays for Chart.js
        $months = [];
        $monthNumbers = [];
        $fullMonths = [];
        $ordersData = [];
        $revenueData = [];

        // INDONESIAN MONTH NAMES
        $indoMonths = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        // Loop 1 to 12 (Jan - Dec)
        for ($i = 1; $i <= 12; $i++) {
            $monthNum = $i;
            $monthName = substr($indoMonths[$i], 0, 3); // Short name Indo (Jan, Feb, ...)

            $months[] = $monthName;
            $monthNumbers[] = $monthNum;
            $fullMonths[] = $indoMonths[$monthNum];

            $data = $chartData->firstWhere('month', $monthNum);
            $ordersData[] = $data ? $data->count : 0;
            $revenueData[] = $data ? $data->total_amount : 0;
        }


        return view('dashboard', compact('totalUsers', 'totalProducts', 'totalOrders', 'revenue', 'months', 'monthNumbers', 'fullMonths', 'ordersData', 'revenueData'));
    }
}
