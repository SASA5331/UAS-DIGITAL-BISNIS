@extends('layouts.admin')

@section('content')
<header class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-black">Kelola Organisasi</h1>
        <p class="text-slate-500">Pantau dan kelola seluruh kepanitiaan/HIMA yang terdaftar.</p>
    </div>
    <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
        class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">
        + Tambah Organisasi
    </button>
</header>

<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
            <tr>
                <th class="px-8 py-4">Organisasi</th>
                <th class="px-8 py-4">Total Event</th>
                <th class="px-8 py-4">Status</th>
                <th class="px-8 py-4">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y border-t">
            @forelse($organizations as $org)
            <tr class="hover:bg-slate-50">
                <td class="px-8 py-6">
                    <p class="font-bold">{{ $org->name }}</p>
                    <p class="text-xs text-slate-400">{{ $org->description }}</p>
                </td>
                <td class="px-8 py-6 font-bold">{{ $org->events_count }} Event</td>
                <td class="px-8 py-6">
                    <form action="{{ route('admin.organizations.update', $org->id) }}" method="POST" class="inline">
                        @csrf @method('PUT')
                        <select name="status" onchange="this.form.submit()"
                            class="border border-slate-200 rounded-xl px-3 py-1 text-sm font-bold
                            {{ $org->status === 'active' ? 'text-green-700 bg-green-50' : ($org->status === 'pending' ? 'text-orange-700 bg-orange-50' : 'text-rose-700 bg-rose-50') }}">
                            <option value="pending"    {{ $org->status === 'pending'    ? 'selected' : '' }}>Pending</option>
                            <option value="active"     {{ $org->status === 'active'     ? 'selected' : '' }}>Active</option>
                            <option value="suspended"  {{ $org->status === 'suspended'  ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </form>
                </td>
                <td class="px-8 py-6">
                    <form action="{{ route('admin.organizations.destroy', $org->id) }}" method="POST"
                          onsubmit="return confirm('Yakin hapus organisasi ini?')">
                        @csrf @method('DELETE')
                        <button class="text-rose-500 font-bold hover:underline text-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-8 py-10 text-center text-slate-500">Belum ada organisasi</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal Tambah --}}
<div id="modalTambah" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-3xl p-8 w-full max-w-md shadow-2xl">
        <h3 class="text-xl font-black mb-6">Tambah Organisasi</h3>
        <form action="{{ route('admin.organizations.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold mb-2">Nama Organisasi</label>
                <input type="text" name="name" class="w-full border border-slate-200 rounded-xl px-4 py-3" required>
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border border-slate-200 rounded-xl px-4 py-3"></textarea>
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">URL Logo (opsional)</label>
                <input type="url" name="logo_url" class="w-full border border-slate-200 rounded-xl px-4 py-3">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 py-3 bg-indigo-600 text-white rounded-xl font-bold">Simpan</button>
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')"
                    class="flex-1 py-3 bg-slate-100 rounded-xl font-bold">Batal</button>
            </div>
        </form>
    </div>
</div>
@endsection