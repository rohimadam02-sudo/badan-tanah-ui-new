@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')

@php
    $role = auth()->user()->role;
    $isEditor = $role == 'editor';
    $isPublisher = $role == 'publisher';
    $isAdmin = in_array($role, ['super_admin', 'admin']);
    $isSuperAdmin = $role == 'super_admin';

    $canEdit = false;
    if ($isAdmin || $isSuperAdmin) {
        $canEdit = true;
    } elseif ($isPublisher) {
        $canEdit = true;
    } elseif ($isEditor && $berita->penulis == auth()->user()->name) {
        $canEdit = true;
    }

    $canDelete = $isAdmin || $isSuperAdmin;

    $isDraft = $berita->status_approval == 'Draft';
    $isPending = $berita->status_approval == 'Menunggu Approval';
    $isApproved = $berita->status_approval == 'Disetujui';
    $isPublished = $berita->status == 'Dipublikasikan';
    $isArchived = $berita->status == 'Arsip';
@endphp

<form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @if (!$canEdit)
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 mb-6">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-ban text-red-600"></i>
                </div>
                <div>
                    <p class="font-bold text-sm">Akses Ditolak</p>
                    <p class="text-sm">Anda tidak memiliki akses untuk mengedit berita ini.</p>
                    <a href="{{ route('admin.berita.index') }}" class="text-sm font-semibold text-red-600 hover:underline mt-1 inline-block">Kembali ke Daftar</a>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================= -->
    <!-- HEADER -->
    <!-- ========================================================= -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Berita</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi berita.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">

            @if ($canEdit)
                <!-- SIMPAN DRAFT -->
                <button type="submit" name="status" value="Draft"
                    class="border border-gray-300 rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-50 transition">
                    <i class="fas fa-file-pen mr-1.5"></i>
                    Simpan Draft
                </button>

                <!-- SUBMIT UNTUK APPROVAL (HANYA EDITOR) -->
                @if ($isEditor && $isDraft)
                    <button type="submit" name="status" value="Menunggu Approval"
                        class="bg-orange-500 hover:bg-orange-600 text-white rounded-lg px-5 py-2 text-sm font-bold transition">
                        <i class="fas fa-paper-plane mr-1.5"></i>
                        Submit untuk Approval
                    </button>
                @endif

                <!-- APPROVE (HANYA PUBLISHER, ADMIN, SUPER ADMIN) -->
                @if (($isPublisher || $isAdmin || $isSuperAdmin) && $isPending)
                    <button type="submit" name="status" value="Approve"
                        formaction="{{ route('admin.berita.approve', $berita->id) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white rounded-lg px-5 py-2 text-sm font-bold transition">
                        <i class="fas fa-check-circle mr-1.5"></i>
                        Approve
                    </button>
                @endif

                <!-- PUBLISH (HANYA PUBLISHER, ADMIN, SUPER ADMIN) -->
                @if (($isPublisher || $isAdmin || $isSuperAdmin) && ($isApproved || $isArchived))
                    <button type="submit" name="status" value="Terbit"
                        formaction="{{ route('admin.berita.publish', $berita->id) }}"
                        class="bg-[#006400] hover:bg-[#005500] text-white rounded-lg px-5 py-2 text-sm font-bold transition">
                        <i class="fas fa-check-circle mr-1.5"></i>
                        {{ $isArchived ? 'Publikasikan Kembali' : 'Publish' }}
                    </button>
                @endif

                <!-- TERBITKAN LANGSUNG (HANYA ADMIN & SUPER ADMIN) -->
                @if ($isAdmin || $isSuperAdmin)
                    <button type="submit" name="status" value="Terbit"
                        class="bg-[#006400] hover:bg-[#005500] text-white rounded-lg px-5 py-2 text-sm font-bold transition">
                        <i class="fas fa-check-circle mr-1.5"></i>
                        Terbitkan
                    </button>
                @endif

                <!-- UNPUBLISH / ARSIPKAN (HANYA PUBLISHER, ADMIN, SUPER ADMIN) -->
                @if (($isPublisher || $isAdmin || $isSuperAdmin) && $isPublished)
                    <button type="submit" name="status" value="Arsip"
                        formaction="{{ route('admin.berita.unpublish', $berita->id) }}"
                        class="border border-gray-300 rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-50 transition">
                        <i class="fas fa-archive mr-1.5"></i>
                        Arsipkan
                    </button>
                @endif

                <!-- HAPUS (HANYA ADMIN & SUPER ADMIN) -->
                @if ($canDelete)
                    <button type="submit" name="status" value="Hapus"
                        formaction="{{ route('admin.berita.destroy', $berita->id) }}"
                        formmethod="POST"
                        onclick="return confirm('Apakah Anda yakin ingin Hapus berita ini?')"
                        class="border border-red-300 text-red-600 hover:bg-red-50 rounded-lg px-4 py-2 text-sm font-medium transition">
                        <i class="fas fa-trash mr-1.5"></i>
                        Hapus
                    </button>
                @endif
            @endif

            <!-- BATAL -->
            <a href="{{ route('admin.berita.index') }}"
                class="border border-gray-300 rounded-lg px-4 py-2 text-sm font-medium hover:bg-gray-50 transition">
                <i class="fas fa-times mr-1.5"></i>
                Batal
            </a>

        </div>
    </div>

    <!-- ========================================================= -->
    <!-- PESAN ERROR -->
    <!-- ========================================================= -->
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

    <!-- ========================================================= -->
    <!-- PESAN SUKSES -->
    <!-- ========================================================= -->
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 mb-6">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <div>
                    <p class="font-bold text-sm">Berhasil!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================================= -->
    <!-- BADGE STATUS -->
    <!-- ========================================================= -->
    <div class="flex flex-wrap items-center gap-3 mb-6">
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold
            @if($isPublished) bg-green-100 text-green-700
            @elseif($isApproved) bg-blue-100 text-blue-700
            @elseif($isPending) bg-orange-100 text-orange-700
            @elseif($isArchived) bg-gray-100 text-gray-500 line-through
            @else bg-yellow-100 text-yellow-700 @endif">
            <span class="w-1.5 h-1.5 rounded-full
                @if($isPublished) bg-green-500
                @elseif($isApproved) bg-blue-500
                @elseif($isPending) bg-orange-500
                @elseif($isArchived) bg-gray-400
                @else bg-yellow-500 @endif">
            </span>
            Status: {{ $berita->status_approval ?? 'Draft' }}
            @if($isPublished)
                <span class="ml-1 text-[8px] bg-green-200 px-1.5 py-0.5 rounded">Published</span>
            @endif
            @if($isArchived)
                <span class="ml-1 text-[8px] bg-gray-200 px-1.5 py-0.5 rounded">Archived</span>
            @endif
        </span>

        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-gray-100 text-gray-600 text-xs font-medium">
            <i class="far fa-eye"></i>
            {{ number_format($berita->views ?? 0, 0, ',', '.') }} Dilihat
        </span>

        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-gray-100 text-gray-600 text-xs font-medium">
            <i class="far fa-calendar-alt"></i>
            {{ $berita->created_at ? $berita->created_at->format('d M Y H:i') : '-' }}
        </span>

        @if($berita->tanggal_publikasi)
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-blue-50 text-blue-600 text-xs font-medium">
                <i class="far fa-calendar-check"></i>
                Publikasi: {{ \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('d M Y') }}
            </span>
        @endif
    </div>

    <!-- ========================================================= -->
    <!-- MAIN CONTENT -->
    <!-- ========================================================= -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- ========================================== -->
        <!-- KOLOM KIRI (2/3) -->
        <!-- ========================================== -->
        <div class="lg:col-span-2 space-y-6">

            <!-- INFORMASI DASAR -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">
                        <i class="fas fa-circle-info text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg text-gray-900">Informasi Dasar</h2>
                        <p class="text-xs text-gray-500">Perbarui informasi utama berita.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Judul Berita <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}"
                            placeholder="Masukkan judul berita"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                            {{ !$canEdit ? 'disabled' : '' }}
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Ringkasan / Lead
                        </label>
                        <textarea name="ringkasan" rows="3"
                            placeholder="Masukkan ringkasan singkat berita"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                            {{ !$canEdit ? 'disabled' : '' }}>{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                        <p class="text-xs text-gray-400 mt-1.5">
                            <i class="fas fa-info-circle mr-1"></i>
                            Opsional. Jika dikosongkan, ringkasan akan dibuat otomatis dari konten.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="kategori" required
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                                {{ !$canEdit ? 'disabled' : '' }}>
                                <option value="Berita" {{ old('kategori', $berita->kategori) == 'Berita' ? 'selected' : '' }}>Berita</option>
                                <option value="Siaran Pers" {{ old('kategori', $berita->kategori) == 'Siaran Pers' ? 'selected' : '' }}>Siaran Pers</option>
                                <option value="Pengumuman" {{ old('kategori', $berita->kategori) == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Tanggal Publikasi
                            </label>
                            <input type="date" name="tanggal_publikasi"
                                value="{{ old('tanggal_publikasi', $berita->tanggal_publikasi ? date('Y-m-d', strtotime($berita->tanggal_publikasi)) : '') }}"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                                {{ !$canEdit ? 'disabled' : '' }}>
                            <p class="text-xs text-gray-400 mt-1.5">
                                <i class="fas fa-info-circle mr-1"></i>
                                Kosongkan jika belum ditentukan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KONTEN BERITA -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center">
                        <i class="fas fa-file-lines text-purple-600"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg text-gray-900">Konten Berita</h2>
                        <p class="text-xs text-gray-500">Perbarui konten berita.</p>
                    </div>
                </div>

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
                        {{ !$canEdit ? 'disabled' : '' }}
                        onchange="document.getElementById('gambarName').textContent = this.files[0]?.name || 'Belum ada file'">
                    <p id="gambarName" class="text-xs text-[#006400] mt-2">Belum ada file</p>
                </div>

                @if ($berita->gambar)
                    <div class="flex items-center gap-3 mb-4 p-3 bg-gray-50 rounded-xl border border-gray-200">
                        <img src="{{ asset('storage/' . $berita->gambar) }}" class="w-16 h-16 object-cover rounded-lg" alt="Gambar berita">
                        <div>
                            <p class="text-xs font-medium text-gray-700">Gambar saat ini</p>
                            <a href="{{ asset('storage/' . $berita->gambar) }}" target="_blank" class="text-xs text-blue-600 hover:underline">Lihat gambar</a>
                        </div>
                    </div>
                @endif

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
                        class="w-full p-4 text-sm border-none focus:ring-0 resize-y"
                        {{ !$canEdit ? 'disabled' : '' }}>{{ old('konten', $berita->konten) }}</textarea>
                </div>
                <p class="text-right text-xs text-gray-400 mt-2">
                    <span id="wordCount">0</span> kata
                </p>
            </div>

            <!-- SEO -->
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
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                            {{ !$canEdit ? 'disabled' : '' }}>
                        <p class="text-right text-xs text-gray-400 mt-1">0/60</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Meta Description</label>
                        <input type="text" name="meta_description" placeholder="Masukkan meta description"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                            {{ !$canEdit ? 'disabled' : '' }}>
                        <p class="text-right text-xs text-gray-400 mt-1">0/160</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">URL Slug</label>
                        <div class="relative">
                            <span class="absolute left-0 top-0 h-full flex items-center pl-4 text-gray-400 text-sm">/</span>
                            <input type="text" name="slug" placeholder="berita/..." value="{{ $berita->slug ?? '' }}"
                                class="w-full border border-gray-300 rounded-xl pl-7 pr-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition"
                                {{ !$canEdit ? 'disabled' : '' }}>
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

            <!-- STATUS & AKSES -->
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
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>

                        @if ($canEdit)
                            <select name="status" id="statusSelect"
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">

                                @if ($isAdmin || $isSuperAdmin)
                                    <option value="Draft" {{ old('status', $berita->status) == 'Draft' || $berita->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="Menunggu Approval" {{ old('status', $berita->status) == 'Menunggu Approval' || $berita->status == 'Menunggu Approval' ? 'selected' : '' }}>Menunggu Approval</option>
                                    <option value="Terbit" {{ old('status', $berita->status) == 'Terbit' || $berita->status == 'Dipublikasikan' ? 'selected' : '' }}>Terbit</option>
                                @elseif ($isEditor)
                                    <option value="Draft" selected>Draft</option>
                                @elseif ($isPublisher)
                                    <option value="Draft" {{ old('status', $berita->status) == 'Draft' || $berita->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="Terbit" {{ old('status', $berita->status) == 'Terbit' || $berita->status == 'Dipublikasikan' ? 'selected' : '' }}>Terbit</option>
                                @else
                                    <option value="Draft" selected>Draft</option>
                                @endif

                            </select>
                        @else
                            <input type="text" value="{{ $berita->status }}" readonly
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm bg-gray-50 text-gray-600">
                        @endif

                        @if ($isEditor)
                            <div class="mt-2 bg-blue-50 border border-blue-100 rounded-lg p-3">
                                <div class="flex items-start gap-2">
                                    <i class="fas fa-info-circle text-blue-500 text-sm mt-0.5"></i>
                                    <p class="text-xs text-blue-700 leading-relaxed">
                                        Sebagai <strong>Editor</strong>, Anda hanya dapat mengubah ke <strong>Draft</strong>.
                                        Klik tombol <strong>"Submit untuk Approval"</strong> untuk mengirim ke Publisher.
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if ($isPublisher)
                            <div class="mt-2 bg-green-50 border border-green-100 rounded-lg p-3">
                                <div class="flex items-start gap-2">
                                    <i class="fas fa-info-circle text-green-500 text-sm mt-0.5"></i>
                                    <p class="text-xs text-green-700 leading-relaxed">
                                        Sebagai <strong>Publisher</strong>, Anda dapat mengubah status ke <strong>Draft</strong>
                                        atau <strong>Terbit</strong>.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Penulis</label>
                        <input type="text" value="{{ $berita->penulis }}" readonly
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm bg-gray-50 text-gray-600">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Slug</label>
                        <input type="text" value="{{ $berita->slug }}" readonly
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm bg-gray-50 text-gray-600">
                    </div>
                </div>
            </div>

            <!-- RIWAYAT APPROVAL -->
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

                    <!-- Status Approval -->
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full
                            @if($isPublished) bg-green-100 text-green-600
                            @elseif($isApproved) bg-blue-100 text-blue-600
                            @elseif($isPending) bg-orange-100 text-orange-600
                            @else bg-gray-100 text-gray-500 @endif
                            flex items-center justify-center flex-shrink-0">
                            <i class="fas
                                @if($isPublished) fa-check-circle
                                @elseif($isApproved) fa-check-circle
                                @elseif($isPending) fa-clock
                                @else fa-file-lines @endif">
                            </i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">Status Approval</p>
                            <p class="text-xs font-semibold
                                @if($isPublished) text-green-600
                                @elseif($isApproved) text-blue-600
                                @elseif($isPending) text-orange-600
                                @else text-gray-500 @endif">
                                {{ $berita->status_approval ?? 'Draft' }}
                            </p>
                            @if($isPublished)
                                <p class="text-[10px] text-gray-400 mt-0.5">
                                    Dipublikasikan pada {{ $berita->tanggal_publikasi ? \Carbon\Carbon::parse($berita->tanggal_publikasi)->format('d M Y H:i') : '-' }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Timeline Approval -->
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider mb-3">Timeline Approval</p>

                        @php
                            $history = $berita->getApprovalHistory();
                        @endphp

                        @if(count($history) > 0)
                            <div class="relative pl-6 space-y-4 before:absolute before:left-1.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-gray-200">
                                @foreach($history as $item)
                                    <div class="relative">
                                        <div class="absolute -left-5 top-1.5 w-3 h-3 rounded-full
                                            {{ $item['action'] == 'created' ? 'bg-gray-400' :
                                               ($item['action'] == 'submit' ? 'bg-orange-500' :
                                               ($item['action'] == 'approve' ? 'bg-green-500' :
                                               ($item['action'] == 'publish' ? 'bg-blue-500' :
                                               ($item['action'] == 'unpublish' ? 'bg-red-500' :
                                               ($item['action'] == 'updated' ? 'bg-yellow-500' :
                                               'bg-gray-500'))))) }}">
                                        </div>
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                                            <div>
                                                <span class="text-xs font-medium text-gray-800">
                                                    {{ ucfirst($item['action']) }}
                                                </span>
                                                <span class="text-[10px] text-gray-500">
                                                    oleh {{ $item['user'] }}
                                                </span>
                                                <span class="text-[9px] text-gray-400 ml-1">
                                                    ({{ $item['role'] }})
                                                </span>
                                                @if($item['note'] ?? false)
                                                    <p class="text-[10px] text-gray-500 italic">{{ $item['note'] }}</p>
                                                @endif
                                            </div>
                                            <span class="text-[9px] text-gray-400 whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($item['timestamp'])->format('d M Y H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-gray-400 italic">Belum ada riwayat approval.</p>
                        @endif
                    </div>

                </div>
            </div>

            <!-- INFORMASI TAMBAHAN -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-100 p-5">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-blue-800">
                            @if ($isEditor)
                                Tips untuk Editor
                            @elseif ($isPublisher)
                                Tips untuk Publisher
                            @elseif ($isAdmin || $isSuperAdmin)
                                Tips untuk Admin
                            @else
                                Informasi
                            @endif
                        </p>
                        <ul class="text-xs text-blue-700 space-y-1 mt-1.5">
                            @if ($isEditor)
                                <li>• Pastikan konten sudah lengkap sebelum Submit</li>
                                <li>• Klik <strong>"Submit untuk Approval"</strong> untuk mengirim ke Publisher</li>
                                <li>• Anda hanya bisa mengedit berita milik sendiri</li>
                                <li>• Status akan berubah menjadi <strong>Menunggu Approval</strong> setelah submit</li>
                            @elseif ($isPublisher)
                                <li>• Review konten dengan teliti sebelum Approve</li>
                                <li>• Setelah Approve, Anda bisa langsung Publish</li>
                                <li>• Anda bisa mengedit semua konten</li>
                            @elseif ($isAdmin || $isSuperAdmin)
                                <li>• Anda memiliki akses penuh ke semua berita</li>
                                <li>• Dapat langsung menerbitkan tanpa approval</li>
                                <li>• Hati-hati saat menghapus berita</li>
                            @else
                                <li>• Hubungi admin jika ada masalah</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </div>

</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.querySelector('textarea[name="konten"]');
        const wordCount = document.getElementById('wordCount');

        if (textarea && wordCount) {
            const initialText = textarea.value.trim();
            const initialWords = initialText.length === 0 ? 0 : initialText.split(/\s+/).length;
            wordCount.textContent = initialWords;

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