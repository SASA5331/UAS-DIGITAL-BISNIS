<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pengurus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">
    <div class="container mx-auto max-w-xl p-6 mt-10">
        <a href="{{ route('pengurus.index') }}" class="text-sm text-indigo-600 mb-4 block">&larr; Kembali</a>
        <h1 class="text-2xl font-bold text-slate-900 mb-6">Edit Pengurus</h1>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <form action="{{ route('pengurus.update', $pengurus->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Pengurus</label>
                    <input type="text" name="name" value="{{ $pengurus->name }}" required class="w-full px-3 py-2 border rounded-lg focus:ring-1 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Jabatan</label>
                    <select name="jabatan_id" required class="w-full px-3 py-2 border rounded-lg focus:ring-1 focus:ring-indigo-500">
                        @foreach($jabatans as $jabatan)
                            <option value="{{ $jabatan->id }}" {{ $pengurus->jabatan_id == $jabatan->id ? 'selected' : '' }}>
                                {{ $jabatan->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Deskripsi</label>
                    <input type="text" name="description" value="{{ $pengurus->description }}" class="w-full px-3 py-2 border rounded-lg focus:ring-1 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Gaji</label>
                    <input type="number" name="salary" value="{{ intval($pengurus->salary) }}" required class="w-full px-3 py-2 border rounded-lg focus:ring-1 focus:ring-indigo-500">
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium">Update</button>
            </form>
        </div>
    </div>
</body>
</html>