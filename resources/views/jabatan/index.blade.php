<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Jabatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">
    <div class="container mx-auto max-w-5xl p-6 mt-10">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Manajemen Jabatan</h1>
                <p class="text-sm text-slate-500">Kelola master data jabatan entitas aplikasi</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('pengurus.index') }}" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-lg text-sm transition shadow-sm">Ke Data Pengurus</a>
                <a href="{{ route('jabatan.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition shadow-sm">+ Tambah Jabatan</a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="mb-4 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-r-lg shadow-sm text-sm">
                <span class="font-semibold">Sukses!</span> {{ $message }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Jabatan</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($jabatans as $jabatan)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-600">#{{ $jabatan->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900">{{ $jabatan->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('jabatan.edit', $jabatan->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                            <form action="{{ route('jabatan.destroy', $jabatan->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus jabatan ini?')" class="text-rose-600 hover:text-rose-900 bg-transparent border-0 cursor-pointer">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-sm text-slate-400 italic">Belum ada data jabatan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>