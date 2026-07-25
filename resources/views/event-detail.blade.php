@extends('layouts.app')

@section('content')

<main class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">
    <!-- Poster -->
    <div class="lg:col-span-1">
        <div class="sticky top-32">
            <img src="{{ ($event->poster_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($event->poster_path))
                            ? asset('storage/' . $event->poster_path)
                            : asset('assets/concert.png') }}" alt="{{ $event->title }}"
                class="w-full rounded-[2.5rem] shadow-2xl border-8 border-white object-cover aspect-[3/4]">
            <div class="mt-8 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                <h4 class="font-bold mb-4">Penyelenggara</h4>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">AH</div>
                    <div>
                        <p class="font-bold text-slate-800">AmikomEventHub</p>
                        <p class="text-xs text-slate-500">Verified Organizer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail -->
    <div class="lg:col-span-2 space-y-12">
        <div class="space-y-4">
            <span class="px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">{{ $event->category->name ?? '-' }}</span>
            <h1 class="text-4xl md:text-5xl font-black leading-tight">{{ $event->title }}</h1>
            <div class="flex flex-wrap gap-6 text-slate-500 font-medium">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($event->date)->translatedFormat('l, d M Y, H:i') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>{{ $event->location }}</span>
                </div>
            </div>
        </div>

        <div>
            <h3 class="text-2xl font-bold mb-4">Deskripsi Event</h3>
            <p class="text-lg text-slate-600 leading-relaxed">
                {{ $event->description }}
            </p>
        </div>

        <div class="bg-indigo-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-indigo-200 relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                <div>
                    <p class="text-indigo-200 font-bold uppercase tracking-widest text-sm mb-2">Harga Tiket</p>
                    <h2 class="text-5xl font-black">
                        @if($event->price == 0)
                            Gratis
                        @else
                            Rp {{ number_format($event->price, 0, ',', '.') }} <span class="text-lg font-medium text-indigo-200">/ orang</span>
                        @endif
                    </h2>
                    <p class="mt-4 text-indigo-100 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Sisa stok: <span class="font-bold underline">{{ $event->stock }} Tiket lagi!</span>
                    </p>
                </div>
                <a href="{{ url('checkout/' . $event->id) }}" class="inline-block px-10 py-5 bg-white text-indigo-600 rounded-2xl font-black text-xl hover:scale-105 transition-transform shadow-xl">
                    Pesan Sekarang
                </a>
            </div>
            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
            <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400 opacity-20 rounded-full"></div>
        </div>

        <div class="space-y-4">
            <h3 class="text-xl font-bold">Kebijakan Tiket</h3>
            <ul class="space-y-3 text-slate-500">
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    E-Ticket akan dikirimkan otomatis setelah pembayaran berhasil.
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Tiket dapat discan di pintu masuk (Check-in).
                </li>
                <li class="flex items-start gap-2 text-rose-500">
                    <svg class="w-5 h-5 text-rose-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Tiket yang sudah dibeli tidak dapat direfund.
                </li>
            </ul>
        </div>
    </div>

    {{-- ========== SSO GOOGLE & REVIEW (UAS) ========== --}}
    <div class="max-w-7xl mx-auto px-6 pb-16 grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">

        {{-- SSO Google -- Soal 1 Fitur 1 --}}
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
            <h3 class="text-xl font-bold mb-2">Pesan Lebih Cepat</h3>
            <p class="text-slate-500 text-sm mb-6">Login dengan Google sekali klik, lalu langsung checkout tanpa isi form panjang.</p>
            @auth
                <div class="flex items-center gap-3 p-4 bg-green-50 rounded-2xl">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" class="w-10 h-10 rounded-full">
                    @endif
                    <div>
                        <p class="font-bold text-green-700">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-green-500">Sudah login — langsung bisa pesan tiket!</p>
                    </div>
                    <form action="{{ route('auth.logout') }}" method="POST" class="ml-auto">
                        @csrf
                        <button class="text-xs text-slate-400 hover:text-rose-500 font-bold">Keluar</button>
                    </form>
                </div>
            @else
                <a href="{{ route('auth.google') }}"
                    class="flex items-center justify-center gap-3 w-full py-4 border-2 border-slate-200 rounded-2xl font-bold hover:border-indigo-400 hover:bg-indigo-50 transition">
                    <svg class="w-5 h-5" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                    Continue with Google
                </a>
            @endauth
        </div>

        {{-- Rating & Review -- Soal 1 Fitur 2 --}}
        @php $reviews = $event->reviews ?? collect(); @endphp
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold">Ulasan Peserta</h3>
                @if($reviews->count() > 0)
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-black text-yellow-400">{{ number_format($reviews->avg('rating'), 1) }}</span>
                    <p class="text-xs text-slate-400">/ {{ $reviews->count() }} ulasan</p>
                </div>
                @endif
            </div>

            @if($event->date <= now())
            @if(session('success'))<div class="mb-4 p-3 bg-green-100 text-green-700 rounded-xl text-sm font-bold">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="mb-4 p-3 bg-red-100 text-red-700 rounded-xl text-sm font-bold">{{ session('error') }}</div>@endif
            <form action="{{ route('reviews.store', $event->id) }}" method="POST" class="mb-6 space-y-4 p-5 bg-slate-50 rounded-2xl">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <input type="text" name="reviewer_name" placeholder="Nama kamu" class="border border-slate-200 rounded-xl px-4 py-2.5 text-sm" required value="{{ auth()->user()->name ?? '' }}">
                    <input type="email" name="reviewer_email" placeholder="Email kamu" class="border border-slate-200 rounded-xl px-4 py-2.5 text-sm" required value="{{ auth()->user()->email ?? '' }}">
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500 mb-1">Rating</p>
                    <input type="hidden" name="rating" id="ratingInput" value="5">
                    <div class="flex gap-1">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" class="star-btn text-yellow-400 text-2xl leading-none" data-value="{{ $i }}">★</button>
                        @endfor
                    </div>
                </div>
                <textarea name="comment" rows="2" placeholder="Ceritakan pengalamanmu..." class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm resize-none"></textarea>
                <button type="submit" class="w-full py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition">Kirim Ulasan</button>
            </form>
            @else
            <div class="mb-4 p-3 bg-amber-50 text-amber-700 rounded-xl text-sm">Ulasan hanya bisa diberikan setelah event selesai.</div>
            @endif

            <div class="space-y-3 max-h-64 overflow-y-auto">
                @forelse($reviews->sortByDesc('created_at') as $review)
                <div class="border border-slate-100 rounded-2xl p-4">
                    <div class="flex justify-between items-start mb-1">
                        <p class="font-bold text-sm">{{ $review->reviewer_name }}</p>
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                    </div>
                    @if($review->comment)<p class="text-xs text-slate-500">{{ $review->comment }}</p>@endif
                </div>
                @empty
                <p class="text-center text-slate-400 text-sm py-4">Belum ada ulasan.</p>
                @endforelse
            </div>
        </div>
    </div>
</main>

@endsection

@push('scripts')
<script>
// Highlight bintang rating
document.querySelectorAll('.star-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const val = this.dataset.value;
        document.getElementById('ratingInput').value = val;
        document.querySelectorAll('.star-btn').forEach((s, i) => {
            s.classList.toggle('text-yellow-400', i < val);
            s.classList.toggle('text-slate-300', i >= val);
        });
    });
});
</script>
@endpush