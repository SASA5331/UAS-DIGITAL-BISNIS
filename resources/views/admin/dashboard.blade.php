@extends('layouts.admin')

@section('content')

<header class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8 md:mb-10">
    <div>
        <h1 class="text-2xl md:text-3xl font-black">Dashboard Ringkasan</h1>
        <p class="text-slate-500 text-sm md:text-base font-medium">Selamat datang kembali, Admin!</p>
    </div>
    <div class="flex items-center gap-4 self-end sm:self-auto">
        <div class="text-right hidden sm:block">
            <p class="font-bold">{{ auth()->user()->name }}</p>
            <p class="text-xs text-slate-400">Penyelenggara Utama</p>
        </div>
        <div class="w-10 h-10 md:w-12 md:h-12 bg-white rounded-2xl shadow-sm border flex items-center justify-center p-1">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6366f1&color=fff" class="rounded-xl w-full h-full object-cover">
        </div>
    </div>
</header>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8 md:mb-10">
    <div class="bg-white p-5 md:p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-10 h-10 md:w-12 md:h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-3 md:mb-4">
            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <p class="text-slate-400 text-xs md:text-sm font-bold uppercase mb-1">Total Pendapatan</p>
        <h3 class="text-xl md:text-2xl font-black">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
    </div>
    <div class="bg-white p-5 md:p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-10 h-10 md:w-12 md:h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-3 md:mb-4">
            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
            </svg>
        </div>
        <p class="text-slate-400 text-xs md:text-sm font-bold uppercase mb-1">Tiket Terjual</p>
        <h3 class="text-xl md:text-2xl font-black">{{ number_format($ticketsSold, 0, ',', '.') }}</h3>
    </div>
    <div class="bg-white p-5 md:p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-10 h-10 md:w-12 md:h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-3 md:mb-4">
            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <p class="text-slate-400 text-xs md:text-sm font-bold uppercase mb-1">Event Aktif</p>
        <h3 class="text-xl md:text-2xl font-black">{{ $activeEvents }} Event</h3>
    </div>
    <div class="bg-white p-5 md:p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-10 h-10 md:w-12 md:h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mb-3 md:mb-4">
            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <p class="text-slate-400 text-xs md:text-sm font-bold uppercase mb-1">Pesanan Pending</p>
        <h3 class="text-xl md:text-2xl font-black">{{ $pendingOrders }} Pesanan</h3>
    </div>
</div>

<!-- === GRAFIK & TOP 5 EVENT === -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 mb-8 md:mb-10 w-full">
    <!-- Chart Pendapatan -->
    <div class="bg-white p-4 md:p-6 rounded-3xl border border-slate-100 shadow-sm w-full overflow-hidden">
        <h3 class="text-base md:text-lg font-bold mb-4 text-slate-700">Pendapatan 6 Bulan Terakhir</h3>
        <div class="relative w-full h-[250px] md:h-[300px]">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Chart Transaksi -->
    <div class="bg-white p-4 md:p-6 rounded-3xl border border-slate-100 shadow-sm w-full overflow-hidden">
        <h3 class="text-base md:text-lg font-bold mb-4 text-slate-700">Jumlah Transaksi per Bulan</h3>
        <div class="relative w-full h-[250px] md:h-[300px]">
            <canvas id="transactionChart"></canvas>
        </div>
    </div>
</div>

<!-- Top 5 Event -->
<div class="bg-white p-5 md:p-6 rounded-3xl border border-slate-100 shadow-sm mb-8 md:mb-10">
    <h3 class="text-base md:text-lg font-bold mb-4 text-slate-700">Top 5 Event Terlaris</h3>
    <div class="space-y-3 md:space-y-4">
        @forelse($topEvents as $index => $event)
        <div class="flex flex-wrap sm:flex-nowrap items-center justify-between p-3 md:p-4 bg-slate-50 rounded-2xl gap-3">
            <div class="flex items-center gap-3 md:gap-4 w-full sm:w-auto">
                <div class="w-8 h-8 md:w-10 md:h-10 shrink-0 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-black text-sm md:text-base">
                    {{ $index + 1 }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="font-bold text-slate-800 text-sm md:text-base truncate">{{ $event->title }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ $event->category->name ?? 'Kategori Umum' }}</p>
                </div>
            </div>
            <div class="text-left sm:text-right w-full sm:w-auto pl-11 sm:pl-0">
                <p class="font-bold text-indigo-600 text-sm md:text-base">{{ $event->transactions_count }} Tiket</p>
            </div>
        </div>
        @empty
        <p class="text-sm text-slate-500">Belum ada data event terjual.</p>
        @endforelse
    </div>
</div>

<!-- Tabel Transaksi Terakhir -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-4">
    <div class="p-5 md:p-8 border-b flex flex-wrap justify-between items-center gap-3">
        <h3 class="font-black text-lg md:text-xl">Transaksi Terakhir</h3>
        <a href="{{ route('admin.transactions.index') ?? '#' }}" class="text-indigo-600 text-sm md:text-base font-bold hover:underline">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[700px]">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-4 md:px-8 py-3 md:py-4 w-1/4">Tgl Transaksi</th>
                    <th class="px-4 md:px-8 py-3 md:py-4 w-1/4">Pembeli</th>
                    <th class="px-4 md:px-8 py-3 md:py-4 w-1/4">Event</th>
                    <th class="px-4 md:px-8 py-3 md:py-4 w-[10%]">Status</th>
                    <th class="px-4 md:px-8 py-3 md:py-4 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($recentTransactions as $trx)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 md:px-8 py-4 md:py-6 text-xs md:text-sm text-slate-600 max-w-[150px] break-words">
                        {{ $trx->created_at->format('d M y - H:i') }}<br>
                        <span class="text-[10px] md:text-xs text-slate-400">{{ $trx->order_id }}</span>
                    </td>
                    <td class="px-4 md:px-8 py-4 md:py-6">
                        <p class="font-bold uppercase tracking-wide text-xs md:text-sm truncate max-w-[120px] md:max-w-[150px]">{{ $trx->customer_name }}</p>
                        <p class="text-[10px] md:text-xs text-slate-400 truncate max-w-[120px] md:max-w-[150px]">{{ $trx->customer_email }}</p>
                    </td>
                    <td class="px-4 md:px-8 py-4 md:py-6 font-medium text-xs md:text-sm text-slate-600 max-w-[150px] truncate">{{ $trx->event->title ?? '-' }}</td>
                    <td class="px-4 md:px-8 py-4 md:py-6 whitespace-nowrap">
                        @if($trx->status === 'settlement' || $trx->status === 'success')
                            <span class="px-2 py-1 md:px-3 md:py-1 bg-green-100 text-green-700 rounded-lg text-[10px] md:text-xs font-bold uppercase">Success</span>
                        @elseif($trx->status === 'pending')
                            <span class="px-2 py-1 md:px-3 md:py-1 bg-orange-100 text-orange-700 rounded-lg text-[10px] md:text-xs font-bold uppercase">Pending</span>
                        @else
                            <span class="px-2 py-1 md:px-3 md:py-1 bg-rose-100 text-rose-700 rounded-lg text-[10px] md:text-xs font-bold uppercase">{{ $trx->status }}</span>
                        @endif
                    </td>
                    <td class="px-4 md:px-8 py-4 md:py-6 font-black text-xs md:text-sm text-indigo-600 whitespace-nowrap text-right">
                        Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 md:px-8 py-8 md:py-10 text-center text-slate-500 text-sm">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- SCRIPT UNTUK RENDER GRAFIK -->
<script>
    const revData = @json($revenueChart);
    const transData = @json($transactionChart);

    const labels = revData.map(item => item.label);
    const amounts = revData.map(item => item.amount);
    const counts = transData.map(item => item.count);

    // Render Chart Pendapatan (Bar)
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Pendapatan (Rp)',
                data: amounts,
                backgroundColor: '#4f46e5',
                borderRadius: 4
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false 
        }
    });

    // Render Chart Transaksi (Line)
    new Chart(document.getElementById('transactionChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Transaksi',
                data: counts,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false 
        }
    });
</script>

@endsection