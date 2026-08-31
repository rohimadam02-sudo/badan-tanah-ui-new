@extends('layouts.admin')

@section('title', 'Tambah Berita')

@section('content')

@php
    $role = auth()->user()->role;
@endphp

<form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Berita</h1>
            <p class="text-sm text-gray-500 mt-1">Lengkapi informasi berita untuk dipublikasikan.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <!-- SIMPAN DRAFT (Semua Role yang bisa membuat) -->
            @if (in_array($role, ['super_admin', 'admin', 'editor']))
                <button type="submit" name="status" value="Draft"
                    class="border border-gray-300 rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-50 transition">
                    <i class="fas fa-file-pen mr-1.5"></i>
                    Simpan Draft
                </button>
            @endif

            <!-- SUBMIT UNTUK APPROVAL (HANYA EDITOR) -->
            @if ($role == 'editor')
                <button type="submit" name="status" value="Menunggu Approval"
                    class="bg-orange-500 hover:bg-orange-600 text-white rounded-lg px-5 py-2 text-sm font-bold transition">
                    <i class="fas fa-paper-plane mr-1.5"></i>
                    Submit untuk Approval
                </button>
            @endif

            <!-- TERBITKAN (HANYA ADMIN & SUPER ADMIN) -->
            @if (in_array($role, ['super_admin', 'admin']))
                <button type="submit" name="status" value="Terbit"
                    class="bg-[#006400] hover:bg-[#005500] text-white rounded-lg px-5 py-2 text-sm font-bold transition">
                    <i class="fas fa-check-circle mr-1.5"></i>
                    Terbitkan
                </button>
            @endif

            <!-- BATAL -->
            <a href="{{ route('admin.berita.index') }}"
                class="border border-gray-300 rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-50 transition">
                <i class="fas fa-times mr-1.5"></i>
                Batal
            </a>
        </div>
    </div>

    <!-- PESAN ERROR -->
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-6">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div>
                    <p class="font-bold text-sm">Terjadi kesalahan:</p>
                    <ul class="list-disc ml-4 text-sm mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- ========================================== -->
        <!-- KOLOM KIRI (2/3) -->
        <!-- ========================================== -->
        <div class="lg:col-span-2 space-y-6">

            <!-- ========================================== -->
            <!-- INFORMASI DASAR -->
            <!-- ========================================== -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                        <i class="fas fa-circle-info text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg text-gray-900">Informasi Dasar</h2>
                        <p class="text-xs text-gray-500">Lengkapi informasi utama berita.</p>
                    </div>
                </div>

                <div class="space-y-4">

                    <!-- JUDUL -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Judul Berita <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul') }}"
                            placeholder="Masukkan judul berita"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                            required>
                    </div>

                    <!-- RINGKASAN -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Ringkasan / Lead
                        </label>
                        <textarea name="ringkasan" rows="3"
                            placeholder="Masukkan ringkasan singkat berita (akan ditampilkan di listing berita)"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">{{ old('ringkasan') }}</textarea>
                        <p class="text-xs text-gray-400 mt-1.5">
                            <i class="fas fa-info-circle mr-1"></i>
                            Opsional. Jika dikosongkan, ringkasan akan dibuat otomatis dari konten.
                        </p>
                    </div>

                    <!-- KATEGORI & TANGGAL -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- KATEGORI -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="kategori" required
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                                <option value="">Pilih Kategori</option>
                                <option value="Berita" {{ old('kategori') == 'Berita' ? 'selected' : '' }}>Berita</option>
                                <option value="Siaran Pers" {{ old('kategori') == 'Siaran Pers' ? 'selected' : '' }}>Siaran Pers</option>
                                <option value="Pengumuman" {{ old('kategori') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                            </select>
                        </div>

                        <!-- TANGGAL PUBLIKASI -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Tanggal Publikasi
                            </label>
                            <input type="date" name="tanggal_publikasi"
                                value="{{ old('tanggal_publikasi', date('Y-m-d')) }}"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                            <p class="text-xs text-gray-400 mt-1.5">
                                <i class="fas fa-info-circle mr-1"></i>
                                Kosongkan jika belum ditentukan.
                            </p>
                        </div>

                    </div>

                </div>

            </div>


            <!-- ========================================== -->
            <!-- KONTEN BERITA -->
            <!-- ========================================== -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center">
                        <i class="fas fa-file-lines text-purple-600"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg text-gray-900">Konten Berita</h2>
                        <p class="text-xs text-gray-500">Tulis konten berita secara lengkap.</p>
                    </div>
                </div>

                <!-- GAMBAR UTAMA -->
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-[#006400] transition mb-6">
                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                    <p class="text-sm font-medium text-gray-600">Upload gambar utama berita</p>
                    <p class="text-xs text-gray-400 mt-1 mb-4">
                        Rekomendasi ukuran: 1200 x 675 px (16:9)
                        <br>
                        Format: JPG, JPEG, PNG (Maks. 2MB)
                    </p>
                    <input type="file" name="gambar" accept="image/jpeg,image/png,image/jpg"
                        class="block w-full text-sm text-gray-600
                        file:mr-4 file:py-2.5 file:px-5
                        file:rounded-xl file:border-0
                        file:text-sm file:font-semibold
                        file:bg-green-50 file:text-green-700
                        hover:file:bg-green-100
                        transition"
                        onchange="document.getElementById('gambarName').textContent = this.files[0]?.name || 'Belum ada file'">
                    <p id="gambarName" class="text-xs text-[#006400] mt-2">Belum ada file</p>
                </div>

                <!-- EDITOR TEKS -->
                <div class="border border-gray-300 rounded-xl overflow-hidden">
                    <div class="bg-gray-50 border-b border-gray-200 p-2 flex flex-wrap gap-1 text-gray-600">
                        <button type="button" class="hover:bg-gray-200 p-1.5 rounded transition" title="Bold"><i class="fas fa-bold"></i></button>
                        <button type="button" class="hover:bg-gray-200 p-1.5 rounded transition" title="Italic"><i class="fas fa-italic"></i></button>
                        <button type="button" class="hover:bg-gray-200 p-1.5 rounded transition" title="Underline"><i class="fas fa-underline"></i></button>
                        <span class="w-px h-6 bg-gray-300 mx-1"></span>
                        <button type="button" class="hover:bg-gray-200 p-1.5 rounded transition" title="List"><i class="fas fa-list-ul"></i></button>
                        <button type="button" class="hover:bg-gray-200 p-1.5 rounded transition" title="Link"><i class="fas fa-link"></i></button>
                        <button type="button" class="hover:bg-gray-200 p-1.5 rounded transition" title="Image"><i class="fas fa-image"></i></button>
                    </div>
                    <textarea name="konten" rows="10" required
                        placeholder="Tulis konten berita di sini..."
                        class="w-full p-4 text-sm border-none focus:ring-0 resize-y">{{ old('konten') }}</textarea>
                </div>
                <p class="text-right text-xs text-gray-400 mt-2">
                    <span id="wordCount">0</span> kata
                </p>

            </div>


            <!-- ========================================== -->
            <!-- SEO (Opsional) -->
            <!-- ========================================== -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
                        <i class="fas fa-magnifying-glass-chart text-amber-600"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg text-gray-900">SEO (Opsional)</h2>
                        <p class="text-xs text-gray-500">Optimasi untuk mesin pencari.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Meta Title</label>
                        <input type="text" name="meta_title" placeholder="Masukkan meta title"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                        <p class="text-right text-xs text-gray-400 mt-1">0/60</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Meta Description</label>
                        <input type="text" name="meta_description" placeholder="Masukkan meta description"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                        <p class="text-right text-xs text-gray-400 mt-1">0/160</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">URL Slug</label>
                        <div class="relative">
                            <span class="absolute left-0 top-0 h-full flex items-center pl-4 text-gray-400 text-sm">/</span>
                            <input type="text" name="slug" placeholder="berita/..." 
                                class="w-full border border-gray-300 rounded-xl pl-7 pr-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                        </div>
                        <p class="text-xs text-gray-400 mt-1.5">
                            <i class="fas fa-info-circle mr-1"></i>
                            Akan digenerate otomatis dari judul jika dikosongkan.
                        </p>
                    </div>
                </div>

            </div>

        </div>


        <!-- ========================================== -->
        <!-- KOLOM KANAN (1/3) -->
        <!-- ========================================== -->
        <div class="space-y-6">

            <!-- ========================================== -->
            <!-- STATUS & AKSES -->
            <!-- ========================================== -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center">
                        <i class="fas fa-toggle-on text-green-600"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg text-gray-900">Status & Akses</h2>
                        <p class="text-xs text-gray-500">Atur status publikasi berita.</p>
                    </div>
                </div>

                <div class="space-y-4">

                    <!-- STATUS -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>
                        <select name="status" id="statusSelect"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">

                            @if (in_array($role, ['super_admin', 'admin']))
                                <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                                <option value="Menunggu Approval" {{ old('status') == 'Menunggu Approval' ? 'selected' : '' }}>Menunggu Approval</option>
                                <option value="Terbit" {{ old('status') == 'Terbit' ? 'selected' : '' }}>Terbit</option>
                            @elseif ($role == 'editor')
                                <option value="Draft" selected>Draft</option>
                            @else
                                <option value="Draft" selected>Draft</option>
                            @endif

                        </select>

                        @if ($role == 'editor')
                            <div class="mt-2 bg-blue-50 border border-blue-100 rounded-lg p-3">
                                <div class="flex items-start gap-2">
                                    <i class="fas fa-info-circle text-blue-500 text-sm mt-0.5"></i>
                                    <p class="text-xs text-blue-700 leading-relaxed">
                                        Sebagai <strong>Editor</strong>, Anda hanya dapat membuat <strong>Draft</strong>.
                                        Submit untuk approval setelah selesai.
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if (in_array($role, ['super_admin', 'admin']))
                            <div class="mt-2 bg-green-50 border border-green-100 rounded-lg p-3">
                                <div class="flex items-start gap-2">
                                    <i class="fas fa-info-circle text-green-500 text-sm mt-0.5"></i>
                                    <p class="text-xs text-green-700 leading-relaxed">
                                        Sebagai <strong>{{ $role == 'super_admin' ? 'Super Admin' : 'Admin' }}</strong>,
                                        Anda dapat langsung <strong>menerbitkan</strong> berita.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- PENULIS -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Penulis</label>
                        <input type="text" name="penulis" value="{{ auth()->user()->name }}" readonly
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm bg-gray-50 text-gray-600">
                    </div>

                </div>

            </div>


            <!-- ========================================== -->
            <!-- RIWAYAT APPROVAL -->
            <!-- ========================================== -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-orange-50 flex items-center justify-center">
                        <i class="fas fa-clock-rotate-left text-orange-600"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg text-gray-900">Riwayat Approval</h2>
                        <p class="text-xs text-gray-500">Informasi status approval berita.</p>
                    </div>
                </div>

                <div class="space-y-4 text-sm">

                    <!-- Dibuat oleh -->
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Dibuat oleh</p>
                            <p class="text-gray-500 text-xs">{{ auth()->user()->name }}</p>
                            <p class="text-gray-400 text-[10px]">{{ now()->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Status Publikasi -->
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-circle-info"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Status Publikasi</p>
                            <p class="text-gray-500 text-xs">
                                @if ($role == 'editor')
                                    Berita akan disubmit ke <strong>Publisher</strong> untuk approval.
                                @elseif (in_array($role, ['super_admin', 'admin']))
                                    Berita dapat langsung diterbitkan.
                                @else
                                    Berita akan tampil di website jika berstatus <strong>Terbit</strong>.
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Alur Approval -->
                    @if ($role == 'editor')
                    <div class="mt-3 bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Alur Approval</p>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-xs font-medium text-gray-700">Draft</span>
                            <span class="text-gray-400">→</span>
                            <span class="text-xs font-medium text-orange-600">Submit</span>
                            <span class="text-gray-400">→</span>
                            <span class="text-xs font-medium text-blue-600">Review Publisher</span>
                            <span class="text-gray-400">→</span>
                            <span class="text-xs font-medium text-green-600">Published</span>
                        </div>
                    </div>
                    @endif

                </div>

            </div>


            <!-- ========================================== -->
            <!-- INFORMASI TAMBAHAN -->
            <!-- ========================================== -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-100 p-5">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-blue-800">Tips</p>
                        <ul class="text-xs text-blue-700 space-y-1 mt-1.5">
                            <li>• Gunakan judul yang menarik dan informatif</li>
                            <li>• Sertakan gambar pendukung untuk meningkatkan visual</li>
                            <li>• Pastikan konten sesuai dengan fakta dan data</li>
                            @if ($role == 'editor')
                            <li>• Submit ke Publisher setelah konten selesai</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </div>

</form>

<script>
    // Word Counter
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.querySelector('textarea[name="konten"]');
        const wordCount = document.getElementById('wordCount');

        if (textarea && wordCount) {
            textarea.addEventListener('input', function() {
                const text = this.value.trim();
                const words = text.length === 0 ? 0 : text.split(/\s+/).length;
                wordCount.textContent = words;
            });
        }

        // File name display
        const gambarInput = document.querySelector('input[name="gambar"]');
        const gambarName = document.getElementById('gambarName');
        if (gambarInput && gambarName) {
            gambarInput.addEventListener('change', function() {
                gambarName.textContent = this.files[0]?.name || 'Belum ada file';
            });
        }
    });
</script>

@endsection