@extends('layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('content')
<main class="max-w-3xl mx-auto px-6 py-20 text-center">
    <div class="bg-white rounded-3xl border border-slate-200 p-12 shadow-sm inline-block w-full max-w-md">

        <div class="w-24 h-24 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h2 class="text-3xl font-black mb-4">Terima Kasih!</h2>
        <p class="text-slate-500 mb-8 leading-relaxed">
            Pembayaran untuk pesanan <strong>{{ $transaction->order_id }}</strong>
            sedang diproses atau telah berhasil.<br><br>
            E-Ticket akan dikirim ke email Anda
            (<strong>{{ $transaction->customer_email }}</strong>)
            setelah pembayaran terkonfirmasi lunas.
        </p>

        <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 mb-8 text-left space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-slate-400 font-bold">Event</span>
                <span class="font-bold text-slate-700">{{ $transaction->event->title ?? '-' }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-slate-400 font-bold">Order ID</span>
                <span class="font-mono text-slate-600">{{ $transaction->order_id }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-slate-400 font-bold">Total Bayar</span>
                <span class="font-black text-indigo-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-slate-400 font-bold">Status</span>
                <span class="px-2 py-0.5 rounded-lg text-xs font-bold
                    {{ strtolower($transaction->status) === 'success' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                    {{ ucfirst($transaction->status) }}
                </span>
            </div>
        </div>

        <a href="{{ route('home') }}"
            class="inline-block px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
            Kembali ke Beranda
        </a>
    </div>
</main>
@endsection