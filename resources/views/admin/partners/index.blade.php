@extends('layouts.admin')

@section('content')

<header class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-black">Kelola Partner</h1>
        <p class="text-slate-500 font-medium">Atur mitra yang mendukung platform AmikomEventHub.</p>
    </div>
    <a href="{{ route('admin.partners.create') }}"
        class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
        + Tambah Partner
    </a>
</header>

{{-- SEARCH --}}
<form method="GET" action="{{ route('admin.partners.index') }}" class="mb-6">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm px-6 py-4 flex gap-4">
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama partner..."
            class="flex-1 px-5 py-3 rounded-xl border-slate-200 border bg-slate-50 focus:ring-2 focus:ring-indigo-500 outline-none transition">
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">Cari</button>
        @if($search)
            <a href="{{ route('admin.partners.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition">Reset</a>
        @endif
    </div>
</form>

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Nama Partner</th>
                    <th class="px-8 py-4">Logo URL</th>
                    <th class="px-8 py-4">Dibuat</th>
                    <th class="px-8 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($partners as $index => $partner)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6 font-bold text-slate-400">{{ $index + 1 }}</td>
                    <td class="px-8 py-6 font-bold">{{ $partner->name }}</td>
                    <td class="px-8 py-6 text-slate-500 text-sm truncate max-w-xs">{{ $partner->logo_url ?? '-' }}</td>
                    <td class="px-8 py-6 text-slate-500 text-sm">{{ $partner->created_at->format('d M Y') }}</td>
                    <td class="px-8 py-6">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.partners.edit', $partner) }}"
                                class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST" onsubmit="return confirm('Yakin hapus partner ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-16 text-center text-slate-400 font-medium">
                        @if($search) Tidak ada partner dengan kata "<strong>{{ $search }}</strong>"
                        @else Belum ada partner. Silakan tambah partner baru.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection