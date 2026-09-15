@extends('layouts.frontend')

@section('title', 'Lamar - ' . $karier->judul)

@section('content')

<section class="bg-[#0B2A4A] py-16">
    <div class="max-w-3xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-white">Lamar Posisi</h1>
        <p class="text-blue-200 mt-2">{{ $karier->judul }}</p>
        <div class="h-1 w-20 bg-blue-500 mt-4"></div>
    </div>
</section>

<section class="bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto px-4">

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl p-4 mb-6">
                <div class="flex items-start gap-3">
                    <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                    <div>
                        <p class="font-bold">Berhasil!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-8">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900">Form Lamaran</h2>
                <p class="text-sm text-gray-500">Isi formulir di bawah untuk melamar posisi ini.</p>
            </div>

            <form action="{{ route('karier.store-lamaran', $karier->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Telepon <span class="text-red-500">*</span></label>
                    <input type="text" name="telepon" value="{{ old('telepon') }}" required
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Upload CV</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-[#006400] transition cursor-pointer"
                         onclick="document.getElementById('cvInput').click()">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-600">Klik untuk upload CV</p>
                        <p class="text-xs text-gray-400">PDF, DOC, DOCX (Max 5MB)</p>
                        <input type="file" id="cvInput" name="cv" accept=".pdf,.doc,.docx" class="hidden"
                               onchange="document.getElementById('cvName').textContent = this.files[0]?.name || 'Belum ada file'">
                        <p id="cvName" class="text-xs text-[#006400] mt-2">Belum ada file</p>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pesan</label>
                    <textarea name="pesan" rows="4" placeholder="Tulis pesan atau cover letter..."
                              class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition resize-y">{{ old('pesan') }}</textarea>
                </div>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('karier') }}" class="border border-gray-300 rounded-xl px-6 py-3 text-sm font-medium hover:bg-gray-50 transition">Batal</a>
                    <button type="submit" class="bg-[#006400] hover:bg-[#005500] text-white px-6 py-3 rounded-xl font-bold text-sm transition shadow-md hover:shadow-lg">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Lamaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection