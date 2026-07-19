<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengurus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">
    <div class="container mx-auto max-w-6xl p-6 mt-10">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Data Struktural Pengurus</h1>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('jabatan.index') }}" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium rounded-lg text-sm">Ke Data Jabatan</a>
                <a href="{{ route('pengurus.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm">+ Tambah Pengurus</a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="mb-4 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 text-sm">
                <span class="font-semibold">Sukses!</span> {{ $message }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Nama Lengkap</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Jabatan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Gaji</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse ($penguruses as $pengurus)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $pengurus->id }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-slate-900">{{ $pengurus->name }}</td>
                        <td class="px-6 py-4 text-sm"><span class="px-2 py-1 bg-indigo-50 text-indigo-700 rounded text-xs border border-indigo-100">{{ $pengurus->jabatan->name }}</span></td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $pengurus->description }}</td>
                        <td class="px-6 py-4 text-sm text-slate-900">Rp {{ number_format($pengurus->salary, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('pengurus.edit', $pengurus->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                            <form action="{{ route('pengurus.destroy', $pengurus->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus?')" class="text-rose-600 hover:text-rose-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-10 text-center text-sm text-slate-400">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>