@extends('layouts.admin')

@section('title', 'Footer')

@section('content')

@php
    $footer = \App\Models\FooterSetting::getSettings();
@endphp

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Footer</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola informasi footer website.</p>
    </div>
</div>

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

<form action="{{ route('admin.footer.update') }}" method="POST">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- KOLOM KIRI --}}
        <div class="space-y-6">

            {{-- INFORMASI DASAR --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h2 class="font-bold text-lg text-gray-900 mb-4">Informasi Dasar</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Website</label>
                        <input type="text" name="nama_website" value="{{ old('nama_website', $footer->nama_website) }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                        <textarea name="deskripsi" rows="3"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">{{ old('deskripsi', $footer->deskripsi) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- KONTAK --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h2 class="font-bold text-lg text-gray-900 mb-4">Kontak</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat</label>
                        <input type="text" name="alamat" value="{{ old('alamat', $footer->alamat) }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email', $footer->email) }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Telepon</label>
                        <input type="text" name="telepon" value="{{ old('telepon', $footer->telepon) }}"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    </div>
                </div>
            </div>

            {{-- QUICK LINKS --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-lg text-gray-900">Tautan Cepat</h2>
                    <button type="button" onclick="addQuickLink()" class="text-sm text-[#006400] hover:underline font-semibold">
                        <i class="fas fa-plus mr-1"></i> Tambah
                    </button>
                </div>

                <div id="quickLinksContainer" class="space-y-3">
                    @php
                        $quickLinks = old('quick_links', $footer->quick_links ?? []);
                        if (empty($quickLinks)) {
                            $quickLinks = [
                                ['label' => 'Tentang Kami', 'url' => '/tentang'],
                                ['label' => 'Aset Persediaan', 'url' => '/aset'],
                                ['label' => 'Pemanfaatan & Kerjasama', 'url' => '/pemanfaatan'],
                                ['label' => 'Publikasi', 'url' => '/publikasi'],
                            ];
                        }
                    @endphp

                    @foreach ($quickLinks as $index => $link)
                        <div class="quick-link-item flex items-center gap-3">
                            <i class="fas fa-grip-vertical text-gray-400 cursor-move"></i>
                            <input type="text" name="quick_links[{{ $index }}][label]" 
                                value="{{ $link['label'] ?? '' }}"
                                placeholder="Label"
                                class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                            <input type="text" name="quick_links[{{ $index }}][url]" 
                                value="{{ $link['url'] ?? '' }}"
                                placeholder="URL"
                                class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                            <button type="button" onclick="removeQuickLink(this)" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    @endforeach
                </div>

                <p class="text-xs text-gray-400 mt-3">Seret ikon <i class="fas fa-grip-vertical"></i> untuk mengatur ulang tautan.</p>
            </div>

        </div>

        {{-- KOLOM KANAN --}}
        <div class="space-y-6">

            {{-- SOSIAL MEDIA --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-lg text-gray-900">Sosial Media</h2>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="show_social_media" value="1"
                            {{ old('show_social_media', $footer->show_social_media) ? 'checked' : '' }}
                            class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[#006400]/30 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#006400]"></div>
                        <span class="ms-3 text-sm font-medium text-gray-700">
                            {{ old('show_social_media', $footer->show_social_media) ? 'Tampilkan' : 'Sembunyikan' }}
                        </span>
                    </label>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Facebook</label>
                        <input type="text" name="facebook" value="{{ old('facebook', $footer->facebook) }}"
                            placeholder="https://facebook.com/..."
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Instagram</label>
                        <input type="text" name="instagram" value="{{ old('instagram', $footer->instagram) }}"
                            placeholder="https://instagram.com/..."
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Twitter / X</label>
                        <input type="text" name="twitter" value="{{ old('twitter', $footer->twitter) }}"
                            placeholder="https://twitter.com/..."
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">LinkedIn</label>
                        <input type="text" name="linkedin" value="{{ old('linkedin', $footer->linkedin) }}"
                            placeholder="https://linkedin.com/..."
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">YouTube</label>
                        <input type="text" name="youtube" value="{{ old('youtube', $footer->youtube) }}"
                            placeholder="https://youtube.com/..."
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
                    </div>
                </div>
            </div>

            {{-- NEWSLETTER --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-lg text-gray-900">Newsletter</h2>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="show_newsletter" value="1"
                            {{ old('show_newsletter', $footer->show_newsletter) ? 'checked' : '' }}
                            class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-[#006400]/30 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#006400]"></div>
                        <span class="ms-3 text-sm font-medium text-gray-700">
                            {{ old('show_newsletter', $footer->show_newsletter) ? 'Tampilkan' : 'Sembunyikan' }}
                        </span>
                    </label>
                </div>
                <p class="text-sm text-gray-500">Tampilkan atau sembunyikan form newsletter di footer.</p>
            </div>

            {{-- FOOTER TEXT --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <h2 class="font-bold text-lg text-gray-900 mb-4">Footer Text</h2>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Teks Footer</label>
                    <textarea name="footer_text" rows="3"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">{{ old('footer_text', $footer->footer_text) }}</textarea>
                    <p class="text-xs text-gray-400 mt-1.5">Gunakan <code>{year}</code> untuk menampilkan tahun otomatis.</p>
                </div>
            </div>

            {{-- TOMBOL SIMPAN --}}
            <button type="submit" class="w-full bg-[#006400] hover:bg-[#005500] text-white px-6 py-3 rounded-xl font-bold text-sm transition shadow-md hover:shadow-lg">
                <i class="fas fa-save mr-1.5"></i>
                Simpan Footer
            </button>

        </div>

    </div>

</form>

<script>
    let linkIndex = {{ count(old('quick_links', $footer->quick_links ?? [])) }};

    function addQuickLink() {
        const container = document.getElementById('quickLinksContainer');
        const index = linkIndex++;

        const div = document.createElement('div');
        div.className = 'quick-link-item flex items-center gap-3';
        div.innerHTML = `
            <i class="fas fa-grip-vertical text-gray-400 cursor-move"></i>
            <input type="text" name="quick_links[${index}][label]" placeholder="Label"
                class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
            <input type="text" name="quick_links[${index}][url]" placeholder="URL"
                class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition">
            <button type="button" onclick="removeQuickLink(this)" class="text-red-500 hover:text-red-700">
                <i class="fas fa-trash"></i>
            </button>
        `;

        container.appendChild(div);
    }

    function removeQuickLink(button) {
        const item = button.closest('.quick-link-item');
        if (item && document.querySelectorAll('.quick-link-item').length > 1) {
            item.remove();
        } else {
            alert('Minimal harus ada 1 tautan.');
        }
    }

    // Toggle status checkbox
    document.querySelectorAll('input[type="checkbox"][name="show_social_media"], input[type="checkbox"][name="show_newsletter"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const label = this.parentElement.nextElementSibling;
            if (label) {
                label.textContent = this.checked ? 'Tampilkan' : 'Sembunyikan';
            }
        });
    });
</script>

@endsection