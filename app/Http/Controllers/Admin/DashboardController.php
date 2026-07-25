<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
<<<<<<< HEAD
=======
use App\Models\User;
>>>>>>> origin/final-branch

class DashboardController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
        $totalRevenue = Transaction::whereIn('status', ['settlement', 'success'])
                            ->sum('total_price');

        $ticketsSold = Transaction::whereIn('status', ['settlement', 'success'])
                            ->count();

        $activeEvents = Event::where('date', '>=', now())->count();

        $pendingOrders = Transaction::where('status', 'pending')->count();

        $recentTransactions = Transaction::with('event')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'recentTransactions'
=======
        // Statistik utama
        $totalRevenue = Transaction::whereIn('status', ['settlement', 'success'])->sum('total_price');
        $ticketsSold  = Transaction::whereIn('status', ['settlement', 'success'])->count();
        $activeEvents = Event::where('date', '>=', now())->count();
        $pendingOrders = Transaction::where('status', 'pending')->count();
        $recentTransactions = Transaction::with('event')->latest()->take(5)->get();

        // === SOAL 2: DATA GRAFIK ===

        // Grafik 1: Pendapatan per bulan (6 bulan terakhir)
        $revenueChart = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenueChart[] = [
                'label'  => $month->format('M Y'),
                'amount' => Transaction::whereIn('status', ['settlement', 'success'])
                            ->whereYear('created_at', $month->year)
                            ->whereMonth('created_at', $month->month)
                            ->sum('total_price'),
            ];
        }

        // Grafik 2: Jumlah transaksi per bulan (6 bulan terakhir)
        $transactionChart = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $transactionChart[] = [
                'label' => $month->format('M Y'),
                'count' => Transaction::whereYear('created_at', $month->year)
                            ->whereMonth('created_at', $month->month)
                            ->count(),
            ];
        }

        // Grafik 3: Top 5 event terlaris
        $topEvents = Event::withCount(['transactions' => function ($q) {
                        $q->whereIn('status', ['settlement', 'success']);
                    }])
                    ->orderByDesc('transactions_count')
                    ->take(5)
                    ->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 'ticketsSold', 'activeEvents', 'pendingOrders',
            'recentTransactions', 'revenueChart', 'transactionChart', 'topEvents'
>>>>>>> origin/final-branch
        ));
    }
}