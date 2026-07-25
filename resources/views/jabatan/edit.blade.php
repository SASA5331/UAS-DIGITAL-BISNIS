<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jabatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">
    <div class="container mx-auto max-w-xl p-6 mt-12">
        <div class="mb-6">
            <a href="{{ route('jabatan.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 transition font-medium">&larr; Kembali ke Daftar</a>
            <h1 class="text-2xl font-bold text-slate-900 mt-2">Ubah Data Jabatan</h1>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Jabatan</label>
                    <input type="text" id="name" name="name" value="{{ $jabatan->name }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm">
                </div>
                
                <div class="pt-2">
                    <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition shadow-sm">Perbarui Data</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>