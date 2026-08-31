@extends('layouts.admin')

@section('title', 'Edit Aset')

@section('content')

<style>
    .tab-section {
        display: none;
    }
    .tab-section.active {
        display: block;
    }
    .tab-btn.active {
        border-bottom: 2px solid #006400;
        color: #006400;
    }
    .tab-btn {
        padding-bottom: 0.75rem;
        border-bottom: 2px solid transparent;
        color: #6b7280;
        font-weight: 500;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s;
        background: none;
        border-top: none;
        border-left: none;
        border-right: none;
    }
    .tab-btn:hover {
        color: #374151;
    }
    #map {
        height: 100%;
        width: 100%;
        border-radius: 0.5rem;
        z-index: 1;
    }
    .map-container {
        height: 350px;
        width: 100%;
        border-radius: 0.5rem;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }
    .dokumen-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem;
        background: #f9fafb;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .dokumen-item input {
        flex: 1;
    }
    .btn-remove {
        color: #ef4444;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
    .btn-remove:hover {
        color: #dc2626;
    }
    .image-preview-container {
        position: relative;
        display: inline-block;
    }
    .image-preview-container img {
        max-height: 200px;
        object-fit: cover;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
    }
    .btn-delete-image {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        cursor: pointer;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .btn-delete-image:hover {
        background: #dc2626;
        transform: scale(1.1);
    }
</style>

<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Aset</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi aset tanah untuk proses verifikasi.</p>
        </div>
        <a href="{{ route('admin.aset.index') }}" class="text-sm text-gray-600 hover:text-[#006400]">Kembali ke Daftar</a>
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

    <form action="{{ route('admin.aset.update', $aset->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- TABS -->
        <div class="flex gap-4 border-b border-gray-200 mb-6 overflow-x-auto">
            <button type="button" onclick="showTab('info')" class="tab-btn active" id="tab-info">Informasi Dasar</button>
            <button type="button" onclick="showTab('lokasi')" class="tab-btn" id="tab-lokasi">Lokasi & Peta</button>
            <button type="button" onclick="showTab('detail')" class="tab-btn" id="tab-detail">Detail Aset</button>
            <button type="button" onclick="showTab('legalitas')" class="tab-btn" id="tab-legalitas">Legalitas</button>
            <button type="button" onclick="showTab('dokumen')" class="tab-btn" id="tab-dokumen">Dokumen</button>
            <button type="button" onclick="showTab('ringkasan')" class="tab-btn" id="tab-ringkasan">Ringkasan</button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- KOLOM KIRI: FORM UTAMA -->
            <div class="lg:col-span-2 space-y-6">
                <!-- TAB 1: INFORMASI DASAR -->
                <div id="tab-content-info" class="tab-section active">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="font-bold text-lg mb-4">Informasi Dasar</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1">Nama Aset <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_lokasi" value="{{ old('nama_lokasi', $aset->nama_lokasi) }}" class="w-full border-gray-300 rounded-lg p-3 text-sm focus:ring-[#006400]" required>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Kategori Aset <span class="text-red-500">*</span></label>
                                    <select name="peruntukan" class="w-full border-gray-300 rounded-lg p-3 text-sm" required>
                                        <option value="">Pilih kategori</option>
                                        <option value="Industri" {{ old('peruntukan', $aset->peruntukan) == 'Industri' ? 'selected' : '' }}>Industri</option>
                                        <option value="Pertanian" {{ old('peruntukan', $aset->peruntukan) == 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                                        <option value="Perumahan" {{ old('peruntukan', $aset->peruntukan) == 'Perumahan' ? 'selected' : '' }}>Perumahan</option>
                                        <option value="Komersial" {{ old('peruntukan', $aset->peruntukan) == 'Komersial' ? 'selected' : '' }}>Komersial</option>
                                        <option value="Sosial" {{ old('peruntukan', $aset->peruntukan) == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Status Aset <span class="text-red-500">*</span></label>
                                    <select name="status" class="w-full border-gray-300 rounded-lg p-3 text-sm" required>
                                        <option value="Tersedia" {{ old('status', $aset->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                        <option value="Dalam Pengembangan" {{ old('status', $aset->status) == 'Dalam Pengembangan' ? 'selected' : '' }}>Dalam Pengembangan</option>
                                        <option value="Dalam Proses" {{ old('status', $aset->status) == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                                        <option value="Terikat" {{ old('status', $aset->status) == 'Terikat' ? 'selected' : '' }}>Terikat</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Luas Tanah (Ha) <span class="text-red-500">*</span></label>
                                    <input type="number" step="0.01" name="luas_hektar" value="{{ old('luas_hektar', $aset->luas_hektar) }}" class="w-full border-gray-300 rounded-lg p-3 text-sm" placeholder="Contoh: 2450.00" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Skema</label>
                                    <select name="skema" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                                        <option value="">Pilih skema</option>
                                        <option value="Sewa" {{ old('skema', $aset->skema) == 'Sewa' ? 'selected' : '' }}>Sewa</option>
                                        <option value="Kerjasama" {{ old('skema', $aset->skema) == 'Kerjasama' ? 'selected' : '' }}>Kerjasama</option>
                                        <option value="Pemanfaatan" {{ old('skema', $aset->skema) == 'Pemanfaatan' ? 'selected' : '' }}>Pemanfaatan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: LOKASI & PETA -->
                <div id="tab-content-lokasi" class="tab-section">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="font-bold text-lg mb-4">Lokasi & Peta</h2>
                        
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Provinsi <span class="text-red-500">*</span></label>
                                    <input type="text" name="provinsi" value="{{ old('provinsi', $aset->provinsi) }}" class="w-full border-gray-300 rounded-lg p-3 text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Kabupaten <span class="text-red-500">*</span></label>
                                    <input type="text" name="kabupaten" value="{{ old('kabupaten', $aset->kabupaten) }}" class="w-full border-gray-300 rounded-lg p-3 text-sm" required>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Latitude</label>
                                    <input type="number" step="0.0000001" name="lat" id="latInput" value="{{ old('lat', $aset->lat) }}" class="w-full border-gray-300 rounded-lg p-3 text-sm" placeholder="-6.7825">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Longitude</label>
                                    <input type="number" step="0.0000001" name="lng" id="lngInput" value="{{ old('lng', $aset->lng) }}" class="w-full border-gray-300 rounded-lg p-3 text-sm" placeholder="106.7825">
                                </div>
                                <div class="flex items-end">
                                    <button type="button" onclick="showLocationOnMap()" class="w-full bg-[#006400] hover:bg-[#005500] text-white px-4 py-2 rounded-lg font-semibold text-sm transition">
                                        <i class="fas fa-search mr-1"></i> Cari Lokasi
                                    </button>
                                </div>
                            </div>
                            
                            <div class="map-container">
                                <div id="map" style="height:100%;width:100%;"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Klik pada peta untuk mengatur koordinat secara langsung.</p>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: DETAIL ASET -->
                <div id="tab-content-detail" class="tab-section">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="font-bold text-lg mb-4">Detail Aset</h2>
                        
                        <div>
                            <label class="block text-sm font-semibold mb-1">Deskripsi Aset</label>
                            <textarea name="deskripsi" rows="6" class="w-full border-gray-300 rounded-lg p-3 text-sm">{{ old('deskripsi', $aset->deskripsi) }}</textarea>
                            <p class="text-xs text-gray-400 mt-1">Deskripsi lengkap tentang aset tanah.</p>
                        </div>
                    </div>
                </div>

                <!-- TAB 4: LEGALITAS -->
                <div id="tab-content-legalitas" class="tab-section">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="font-bold text-lg mb-4">Legalitas</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1">Sumber Perolehan</label>
                                <select name="sumber_perolehan" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                                    <option value="">Pilih sumber perolehan</option>
                                    <option value="Pembelian" {{ old('sumber_perolehan', $aset->sumber_perolehan ?? '') == 'Pembelian' ? 'selected' : '' }}>Pembelian</option>
                                    <option value="Sewa" {{ old('sumber_perolehan', $aset->sumber_perolehan ?? '') == 'Sewa' ? 'selected' : '' }}>Sewa</option>
                                    <option value="Hibah" {{ old('sumber_perolehan', $aset->sumber_perolehan ?? '') == 'Hibah' ? 'selected' : '' }}>Hibah</option>
                                    <option value="Tukar Menukar" {{ old('sumber_perolehan', $aset->sumber_perolehan ?? '') == 'Tukar Menukar' ? 'selected' : '' }}>Tukar Menukar</option>
                                    <option value="Lelang" {{ old('sumber_perolehan', $aset->sumber_perolehan ?? '') == 'Lelang' ? 'selected' : '' }}>Lelang</option>
                                    <option value="Pengadaan" {{ old('sumber_perolehan', $aset->sumber_perolehan ?? '') == 'Pengadaan' ? 'selected' : '' }}>Pengadaan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Nilai Perkiraan</label>
                                <input type="text" name="nilai_perkiraan" value="{{ old('nilai_perkiraan', $aset->nilai_perkiraan ?? '') }}" placeholder="Rp" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 5: DOKUMEN -->
                <div id="tab-content-dokumen" class="tab-section">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="font-bold text-lg">Dokumen</h2>
                            <button type="button" onclick="addDokumen()" class="bg-[#006400] hover:bg-[#005500] text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                                <i class="fas fa-plus mr-1"></i> Tambah Dokumen
                            </button>
                        </div>
                        
                        <div id="dokumenContainer">
                            @php
                                $dokumenList = old('dokumen', $aset->dokumen ?? []);
                                if (empty($dokumenList)) {
                                    $dokumenList = [''];
                                }
                            @endphp
                            @foreach ($dokumenList as $dok)
                                @if (!empty($dok) || $loop->first)
                                    <div class="dokumen-item">
                                        <input type="text" name="dokumen[]" value="{{ $dok }}" placeholder="Nama dokumen..." class="flex-1 border-gray-300 rounded-lg p-2 text-sm">
                                        <button type="button" onclick="removeDokumen(this)" class="btn-remove"><i class="fas fa-times"></i></button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Tambahkan nama dokumen pendukung aset.</p>
                    </div>
                </div>

                <!-- TAB 6: RINGKASAN -->
                <div id="tab-content-ringkasan" class="tab-section">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="font-bold text-lg mb-4">Ringkasan</h2>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold mb-1">Peruntukan Rencana</label>
                                <select name="skema" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                                    <option value="">Pilih peruntukan rencana</option>
                                    <option value="Sewa" {{ old('skema', $aset->skema) == 'Sewa' ? 'selected' : '' }}>Sewa</option>
                                    <option value="Kerjasama" {{ old('skema', $aset->skema) == 'Kerjasama' ? 'selected' : '' }}>Kerjasama</option>
                                    <option value="Pemanfaatan" {{ old('skema', $aset->skema) == 'Pemanfaatan' ? 'selected' : '' }}>Pemanfaatan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Tahun Perolehan</label>
                                <input type="number" name="tahun_perolehan" value="{{ old('tahun_perolehan', $aset->tahun_perolehan ?? '') }}" placeholder="2025" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: GAMBAR -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="font-bold text-lg mb-4">Gambar Aset</h2>
                    
                    @if ($aset->gambar)
                        <div class="mb-4">
                            <p class="text-xs text-gray-500 mb-2">Gambar saat ini:</p>
                            <div class="image-preview-container">
                                <img src="{{ asset('storage/' . $aset->gambar) }}" alt="{{ $aset->nama_lokasi }}" class="w-full h-48 object-cover rounded-lg border border-gray-200">
                            </div>
                            <p class="text-xs text-gray-400 mt-1">{{ basename($aset->gambar) }}</p>
                        </div>
                    @endif
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-[#006400] transition cursor-pointer"
                         onclick="document.getElementById('gambarInput').click()">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                        <p class="text-sm font-medium text-gray-600">Upload gambar baru (kosongkan jika tidak diubah)</p>
                        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, GIF, WebP (Max 2MB)</p>
                        <input type="file" id="gambarInput" name="gambar" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                               class="hidden" onchange="previewImage(this)">
                        <p id="gambarName" class="text-xs text-[#006400] mt-2">Belum ada file</p>
                    </div>
                    
                    <div id="imagePreview" class="hidden mt-4">
                        <p class="text-xs text-gray-500 mb-2">Preview:</p>
                        <img id="previewImg" class="w-full h-48 object-cover rounded-lg border border-gray-200">
                    </div>
                </div>
            </div>
        </div>

        <!-- AKSI BAWAH -->
        <div class="mt-8 flex justify-end gap-4">
            <a href="{{ route('admin.aset.index') }}" class="border border-gray-300 rounded-lg px-6 py-3 text-sm font-medium hover:bg-gray-50 transition">Batal</a>
            <button type="submit" class="bg-[#006400] hover:bg-[#005500] text-white px-6 py-3 rounded-lg font-bold text-sm transition">Update Data</button>
        </div>
    </form>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // =========================================================
    // TAB SWITCHER
    // =========================================================
    function showTab(tabName) {
        document.querySelectorAll('.tab-section').forEach(el => {
            el.classList.remove('active');
        });
        document.getElementById('tab-content-' + tabName).classList.add('active');
        
        document.querySelectorAll('.tab-btn').forEach(el => {
            el.classList.remove('active');
        });
        document.getElementById('tab-' + tabName).classList.add('active');
        
        // Jika tab lokasi, refresh map
        if (tabName === 'lokasi') {
            setTimeout(() => {
                if (map) {
                    map.invalidateSize();
                }
            }, 300);
        }
    }

    // =========================================================
    // MAP
    // =========================================================
    let map = null;
    let marker = null;

    function initMap(lat = -2.5, lng = 118.0) {
        if (map) {
            map.remove();
            map = null;
        }
        
        map = L.map('map').setView([lat, lng], 5);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        
        // Jika ada koordinat, tambahkan marker
        const latVal = parseFloat(document.getElementById('latInput').value);
        const lngVal = parseFloat(document.getElementById('lngInput').value);
        
        if (!isNaN(latVal) && !isNaN(lngVal) && latVal !== 0 && lngVal !== 0) {
            addMarker(latVal, lngVal);
            map.setView([latVal, lngVal], 12);
        }
        
        // Click on map to set coordinates
        map.on('click', function(e) {
            const lat = e.latlng.lat.toFixed(7);
            const lng = e.latlng.lng.toFixed(7);
            document.getElementById('latInput').value = lat;
            document.getElementById('lngInput').value = lng;
            addMarker(parseFloat(lat), parseFloat(lng));
            map.setView([lat, lng], 12);
        });
    }

    function addMarker(lat, lng) {
        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker([lat, lng]).addTo(map)
            .bindPopup('Lokasi Aset')
            .openPopup();
    }

    function showLocationOnMap() {
        const lat = parseFloat(document.getElementById('latInput').value);
        const lng = parseFloat(document.getElementById('lngInput').value);
        
        if (isNaN(lat) || isNaN(lng) || lat === 0 || lng === 0) {
            alert('Masukkan latitude dan longitude yang valid terlebih dahulu.');
            return;
        }
        
        if (!map) {
            initMap(lat, lng);
        } else {
            addMarker(lat, lng);
            map.setView([lat, lng], 12);
        }
    }

    // =========================================================
    // DOKUMEN
    // =========================================================
    function addDokumen() {
        const container = document.getElementById('dokumenContainer');
        const div = document.createElement('div');
        div.className = 'dokumen-item';
        div.innerHTML = `
            <input type="text" name="dokumen[]" placeholder="Nama dokumen..." class="flex-1 border-gray-300 rounded-lg p-2 text-sm">
            <button type="button" onclick="removeDokumen(this)" class="btn-remove"><i class="fas fa-times"></i></button>
        `;
        container.appendChild(div);
    }

    function removeDokumen(button) {
        const container = document.getElementById('dokumenContainer');
        if (container.children.length > 1) {
            button.parentElement.remove();
        } else {
            alert('Minimal harus ada 1 dokumen.');
        }
    }

    // =========================================================
    // GAMBAR PREVIEW
    // =========================================================
    function previewImage(input) {
        const file = input.files[0];
        const nameDisplay = document.getElementById('gambarName');
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        
        if (file) {
            nameDisplay.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            nameDisplay.textContent = 'Belum ada file';
            preview.classList.add('hidden');
        }
    }

    // =========================================================
    // INIT
    // =========================================================
    document.addEventListener('DOMContentLoaded', function() {
        initMap();
        
        // Enter key on lat/lng input to show location
        document.getElementById('latInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') showLocationOnMap();
        });
        document.getElementById('lngInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') showLocationOnMap();
        });
    });
</script>

@endsection