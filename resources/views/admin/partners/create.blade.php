@extends('layouts.admin')

@section('content')

<div class="max-w-xl">
    <div class="mb-8">
        <h1 class="text-3xl font-black">Tambah Partner</h1>
        <p class="text-slate-500 font-medium">Tambahkan mitra baru ke platform.</p>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8">
        <form action="{{ route('admin.partners.store') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Partner <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required value="{{ old('name') }}" placeholder="cth: Google, Microsoft..."
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Logo URL</label>
                <input type="text" name="logo_url" value="{{ old('logo_url') }}" placeholder="https://example.com/logo.png"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.partners.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition">Batal</a>
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">Simpan Partner</button>
            </div>
        </form>
    </div>
</div>

@endsection