@extends('layouts.admin')

@section('content')

<header class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-black">Kelola Kategori</h1>
        <p class="text-slate-500 font-medium">Atur kategori event yang tersedia di platform.</p>
    </div>
    <button onclick="document.getElementById('modal-tambah').classList.remove('hidden')"
        class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition">
        + Tambah Kategori
    </button>
</header>

{{-- SEARCH --}}
<form method="GET" action="{{ route('admin.categories.index') }}" class="mb-6">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm px-6 py-4 flex gap-4">
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama kategori..."
            class="flex-1 px-5 py-3 rounded-xl border-slate-200 border bg-slate-50 focus:ring-2 focus:ring-indigo-500 outline-none transition">
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">Cari</button>
        @if($search)
            <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition">Reset</a>
        @endif
    </div>
</form>

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Nama Kategori</th>
                    <th class="px-8 py-4">Slug</th>
                    <th class="px-8 py-4">Dibuat</th>
                    <th class="px-8 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($categories as $index => $category)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6 font-bold text-slate-400">{{ $index + 1 }}</td>
                    <td class="px-8 py-6">
                        <span class="px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold">{{ $category->name }}</span>
                    </td>
                    <td class="px-8 py-6 text-slate-500 text-sm">{{ $category->slug }}</td>
                    <td class="px-8 py-6 text-slate-500 text-sm">{{ $category->created_at->format('d M Y') }}</td>
                    <td class="px-8 py-6">
                        <div class="flex gap-2">
                            {{-- Tombol Edit --}}
                            <button onclick="openEditModal({{ $category->id }}, '{{ $category->name }}')"
                                class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin hapus kategori ini?')">
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
                        @if($search) Tidak ada kategori dengan kata "<strong>{{ $search }}</strong>"
                        @else Belum ada kategori. Silakan tambah kategori baru.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div id="modal-tambah" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div class="bg-white rounded-3xl p-8 w-full max-w-md shadow-2xl">
        <h2 class="text-xl font-black mb-6">Tambah Kategori Baru</h2>
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Kategori</label>
                <input type="text" name="name" required placeholder="cth: Musik, Teknologi..."
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="document.getElementById('modal-tambah').classList.add('hidden')"
                    class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modal-edit" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div class="bg-white rounded-3xl p-8 w-full max-w-md shadow-2xl">
        <h2 class="text-xl font-black mb-6">Edit Kategori</h2>
        <form id="form-edit" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Kategori</label>
                <input type="text" id="edit-name" name="name" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="document.getElementById('modal-edit').classList.add('hidden')"
                    class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, name) {
    document.getElementById('edit-name').value = name;
    document.getElementById('form-edit').action = '/admin/categories/' + id;
    document.getElementById('modal-edit').classList.remove('hidden');
}
</script>

@endsection