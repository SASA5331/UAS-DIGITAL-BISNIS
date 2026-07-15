@extends('layouts.app')

@section('content')

<!-- HERO -->
<section class="w-full px-6 lg:px-12 xl:px-20 py-10 md:py-16 flex flex-col lg:flex-row items-center justify-between gap-12">

    <!-- LEFT -->
    <div class="flex-1 space-y-6 text-center lg:text-left max-w-2xl">

        <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-xs sm:text-sm font-bold uppercase tracking-wider">
            #1 Event Platform
        </span>

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight">
            Temukan & Pesan
            <span class="text-indigo-600">Tiket Event</span>
            Impianmu.
        </h1>

        <p class="text-base sm:text-lg text-slate-500 leading-relaxed">
            Dari konser musik hingga workshop teknologi, semua ada di genggamanmu.
            Pesan aman & cepat dengan Midtrans.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">

            <a href="#events"
                class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold text-base shadow-xl shadow-indigo-200 hover:scale-105 transition-transform text-center">

                Mulai Jelajah

            </a>

            <a href="#"
                class="px-6 py-3 border-2 border-slate-200 rounded-2xl font-bold text-base hover:border-indigo-600 hover:text-indigo-600 transition text-center">

                Cara Pesan

            </a>

        </div>

    </div>

    <!-- RIGHT -->
    <div class="flex-1 relative w-full max-w-xl">

        <div class="absolute -top-6 -left-6 w-40 h-40 bg-indigo-400 rounded-full blur-3xl opacity-20">
        </div>

        <div class="absolute -bottom-6 -right-6 w-40 h-40 bg-purple-400 rounded-full blur-3xl opacity-20">
        </div>

        <img src="{{ asset('assets/concert.png') }}"
            alt="Concert"
            class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover">

    </div>

</section>

<!-- EVENTS -->
<section id="events" class="w-full px-6 lg:px-12 xl:px-20 py-12">

    <!-- TITLE -->
    <div class="mb-10">

        <h2 class="text-3xl font-extrabold mb-2">
            Event Terdekat
        </h2>

        <p class="text-slate-500">
            Jangan sampai ketinggalan acara seru minggu ini!
        </p>

    </div>

    <!-- FILTER -->
    <div class="flex flex-wrap gap-3 mb-10">

        <!-- Semua -->
        <a href="/"
            class="px-5 py-2 rounded-2xl font-semibold transition

            {{ request('category') == ''
                ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200'
                : 'bg-white border border-slate-200 hover:border-indigo-500 hover:text-indigo-600' }}">

            Semua

        </a>

        <!-- CATEGORY -->
        @foreach($categories as $cat)

            <a href="/?category={{ $cat->slug }}"
                class="px-5 py-2 rounded-2xl font-semibold transition

                {{ request('category') == $cat->slug
                    ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200'
                    : 'bg-white border border-slate-200 hover:border-indigo-500 hover:text-indigo-600' }}">

                {{ $cat->name }}

            </a>

        @endforeach

    </div>

    <!-- GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

        @forelse($events as $event)

            <!-- CARD -->
            <div class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">

                <!-- IMAGE -->
                <div class="relative overflow-hidden h-72">

                    <img src="
                        @if($event->category_id == 1)

                            {{ asset('assets/concert.png') }}

                        @elseif($event->category_id == 2)

                            {{ asset('assets/workshop.png') }}

                        @elseif($event->category_id == 3)

                            {{ asset('assets/hackathon.png') }}

                        @else

                            {{ asset('assets/concert.png') }}

                        @endif
                    "
                    alt="{{ $event->title }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                    <!-- CATEGORY -->
                    <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">

                        {{ $event->category->name }}

                    </div>

                </div>

                <!-- CONTENT -->
                <div class="p-5">

                    <h3 class="text-xl font-bold mb-3 group-hover:text-indigo-600 transition line-clamp-2">

                        {{ $event->title }}

                    </h3>

                    <!-- DATE -->
                    <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">

                        <svg class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>

                        </svg>

                        <span>
                            {{ \Carbon\Carbon::parse($event->date)->format('d F Y, H:i') }}
                        </span>

                    </div>

                    <!-- FOOTER -->
                    <div class="flex justify-between items-center pt-4 border-t gap-3">

                        <span class="text-xl sm:text-2xl font-black text-indigo-600">

                            @if($event->price == 0)

                                Gratis

                            @else

                                Rp {{ number_format($event->price, 0, ',', '.') }}

                            @endif

                        </span>

                        <a href="{{ route('events.show', $event->id) }}"
                            class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition whitespace-nowrap">

                            Lihat Detail

                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-span-3 text-center py-20">

                <h3 class="text-2xl font-bold text-slate-700 mb-2">
                    Event tidak ditemukan
                </h3>

                <p class="text-slate-500">
                    Belum ada event pada kategori ini.
                </p>

            </div>

        @endforelse

    </div>

</section>

{{-- SECTION PARTNER --}}
<section class="w-full px-6 lg:px-12 xl:px-20 py-16 bg-slate-50">
    <div class="mb-10 text-center">
        <h2 class="text-3xl font-extrabold mb-2">Partner Kami</h2>
        <p class="text-slate-500">Didukung oleh mitra-mitra terpercaya platform AmikomEventHub.</p>
    </div>

    @if($partners->count() > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @foreach($partners as $partner)
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col items-center gap-3 hover:shadow-md transition">
            @if($partner->logo_url)
                <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}"
                    class="h-12 object-contain" onerror="this.style.display='none'">
            @else
                <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 font-black text-lg">
                    {{ strtoupper(substr($partner->name, 0, 1)) }}
                </div>
            @endif
            <span class="text-sm font-bold text-slate-700 text-center">{{ $partner->name }}</span>
        </div>
        @endforeach
    </div>
    @else
    <p class="text-center text-slate-400">Belum ada partner yang terdaftar.</p>
    @endif
</section>

@endsection