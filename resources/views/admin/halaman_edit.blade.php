<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Edit Halaman</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden text-gray-800">

    <aside class="w-64 bg-[#001F3F] text-white flex flex-col">
        <div class="p-6 border-b border-gray-700">
            <h2 class="font-bold text-xl">BT Admin</h2>
        </div>
       <nav class="flex-1 p-4 space-y-2">
    <a href="{{ route('admin.dashboard') }}" class="block p-3 bg-gray-700/50 rounded hover:bg-gray-700 transition">Dashboard</a>
    <a href="{{ route('admin.aset.index') }}" class="block p-3 hover:bg-gray-700 rounded transition">Aset Tanah</a>
    <a href="{{ route('admin.berita.index') }}" class="block p-3 hover:bg-gray-700 rounded transition">Publikasi</a>
    <a href="{{ route('admin.halaman.edit.tentang') }}" class="block p-3 hover:bg-gray-700 rounded transition">Edit Halaman Tentang</a>
    <a href="{{ route('admin.halaman.edit.partnership') }}" class="block p-3 hover:bg-gray-700 rounded transition">Edit Halaman Pemanfaatan</a>
</nav>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white h-16 border-b border-gray-200 flex items-center justify-between px-6">
            <h1 class="font-bold text-xl">Edit Halaman</h1>
            <a href="{{ route('about') }}" class="text-sm text-gray-600">Kembali ke Halaman Publik</a>
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.halaman.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Halaman</label>
                        <input type="text" name="judul" value="{{ $halaman->judul }}" class="w-full border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Halaman</label>
                        <textarea name="isi" rows="10" class="w-full border-gray-300 rounded-md" required>{{ $halaman->isi }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Halaman</label>
                        <input type="file" name="gambar" class="w-full border-gray-300 rounded-md" accept="image/*">
                        @if ($halaman->gambar)
                            <p class="text-xs text-gray-500 mt-2">Gambar lama: <a href="{{ asset('storage/' . $halaman->gambar) }}" target="_blank" class="text-blue-600 underline">Lihat</a></p>
                        @endif
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-[#006400] text-white px-6 py-3 rounded font-bold">Simpan Halaman</button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>