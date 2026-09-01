@extends('layouts.admin')

@section('title', 'Tambah Aset Baru')

@section('content')

<style>
    /* =========================================================
       DRAG & DROP UPLOAD
    ========================================================= */
    .drop-zone {
        border: 2px dashed #d1d5db;
        border-radius: 0.75rem;
        padding: 2.5rem 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f9fafb;
        position: relative;
    }

    .drop-zone:hover {
        border-color: #006400;
        background: #f0fdf4;
    }

    .drop-zone.dragover {
        border-color: #006400;
        background: #dcfce7;
        transform: scale(1.01);
    }

    .drop-zone .icon {
        font-size: 3rem;
        color: #9ca3af;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }

    .drop-zone:hover .icon {
        color: #006400;
        transform: scale(1.05);
    }

    .drop-zone .text {
        font-size: 0.875rem;
        font-weight: 500;
        color: #6b7280;
    }

    .drop-zone .hint {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 0.25rem;
    }

    /* =========================================================
       PREVIEW IMAGE
    ========================================================= */
    .image-preview-container {
        display: none;
        margin-top: 1rem;
    }

    .image-preview-container.active {
        display: block;
    }

    .image-preview-wrapper {
        position: relative;
        display: inline-block;
        border-radius: 0.75rem;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        width: 100%;
    }

    .image-preview-wrapper img {
        max-height: 250px;
        width: 100%;
        object-fit: contain;
        display: block;
        background: #f9fafb;
    }

    .image-preview-wrapper .btn-remove-image {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        font-size: 0.875rem;
        z-index: 10;
    }

    .image-preview-wrapper .btn-remove-image:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

    .image-preview-wrapper .file-name {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 0.5rem 1rem;
        font-size: 0.75rem;
        text-align: center;
        backdrop-filter: blur(4px);
    }

    /* =========================================================
       TAB
    ========================================================= */
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
    .dokumen-item input[type="text"] {
        flex: 1;
    }
    .dokumen-item input[type="file"] {
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
</style>

<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Aset Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Lengkapi informasi aset tanah untuk proses verifikasi.</p>
        </div>
        <a href="{{ route('admin.aset.index') }}" class="text-sm text-gray-600 hover:text-[#006400]">Kembali ke Daftar</a>
    </div>

    <form action="{{ route('admin.aset.store') }}" method="POST" enctype="multipart/form-data" id="assetForm">
        @csrf
        
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
                                <input type="text" name="nama_lokasi" value="{{ old('nama_lokasi') }}" class="w-full border-gray-300 rounded-lg p-3 text-sm focus:ring-[#006400]" required>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Kategori Aset <span class="text-red-500">*</span></label>
                                    <select name="peruntukan" class="w-full border-gray-300 rounded-lg p-3 text-sm" required>
                                        <option value="">Pilih kategori</option>
                                        <option value="Industri" {{ old('peruntukan') == 'Industri' ? 'selected' : '' }}>Industri</option>
                                        <option value="Pertanian" {{ old('peruntukan') == 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                                        <option value="Perumahan" {{ old('peruntukan') == 'Perumahan' ? 'selected' : '' }}>Perumahan</option>
                                        <option value="Komersial" {{ old('peruntukan') == 'Komersial' ? 'selected' : '' }}>Komersial</option>
                                        <option value="Sosial" {{ old('peruntukan') == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Status Aset <span class="text-red-500">*</span></label>
                                    <select name="status" class="w-full border-gray-300 rounded-lg p-3 text-sm" required>
                                        <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                        <option value="Dalam Pengembangan" {{ old('status') == 'Dalam Pengembangan' ? 'selected' : '' }}>Dalam Pengembangan</option>
                                        <option value="Dalam Proses" {{ old('status') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
                                        <option value="Terikat" {{ old('status') == 'Terikat' ? 'selected' : '' }}>Terikat</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Luas Tanah (Ha) <span class="text-red-500">*</span></label>
                                    <input type="number" step="0.01" name="luas_hektar" value="{{ old('luas_hektar') }}" class="w-full border-gray-300 rounded-lg p-3 text-sm" placeholder="Contoh: 2450.00" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Skema</label>
                                    <select name="skema" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                                        <option value="">Pilih skema</option>
                                        <option value="Sewa" {{ old('skema') == 'Sewa' ? 'selected' : '' }}>Sewa</option>
                                        <option value="Kerjasama" {{ old('skema') == 'Kerjasama' ? 'selected' : '' }}>Kerjasama</option>
                                        <option value="Pemanfaatan" {{ old('skema') == 'Pemanfaatan' ? 'selected' : '' }}>Pemanfaatan</option>
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
                                    <input type="text" name="provinsi" value="{{ old('provinsi') }}" class="w-full border-gray-300 rounded-lg p-3 text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Kabupaten <span class="text-red-500">*</span></label>
                                    <input type="text" name="kabupaten" value="{{ old('kabupaten') }}" class="w-full border-gray-300 rounded-lg p-3 text-sm" required>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Latitude</label>
                                    <input type="number" step="0.0000001" name="lat" id="latInput" value="{{ old('lat') }}" class="w-full border-gray-300 rounded-lg p-3 text-sm" placeholder="-6.7825">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Longitude</label>
                                    <input type="number" step="0.0000001" name="lng" id="lngInput" value="{{ old('lng') }}" class="w-full border-gray-300 rounded-lg p-3 text-sm" placeholder="106.7825">
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
                            <textarea name="deskripsi" rows="6" class="w-full border-gray-300 rounded-lg p-3 text-sm">{{ old('deskripsi') }}</textarea>
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
                                    <option value="Pembelian" {{ old('sumber_perolehan') == 'Pembelian' ? 'selected' : '' }}>Pembelian</option>
                                    <option value="Sewa" {{ old('sumber_perolehan') == 'Sewa' ? 'selected' : '' }}>Sewa</option>
                                    <option value="Hibah" {{ old('sumber_perolehan') == 'Hibah' ? 'selected' : '' }}>Hibah</option>
                                    <option value="Tukar Menukar" {{ old('sumber_perolehan') == 'Tukar Menukar' ? 'selected' : '' }}>Tukar Menukar</option>
                                    <option value="Lelang" {{ old('sumber_perolehan') == 'Lelang' ? 'selected' : '' }}>Lelang</option>
                                    <option value="Pengadaan" {{ old('sumber_perolehan') == 'Pengadaan' ? 'selected' : '' }}>Pengadaan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Nilai Perkiraan</label>
                                <input type="text" name="nilai_perkiraan" value="{{ old('nilai_perkiraan') }}" placeholder="Rp" class="w-full border-gray-300 rounded-lg p-3 text-sm">
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
                            <div class="dokumen-item flex flex-col sm:flex-row items-start sm:items-center gap-3 p-3 bg-gray-50 rounded-lg mb-3">
                                <div class="flex-1 w-full">
                                    <input type="text" name="dokumen[]" placeholder="Nama dokumen..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                </div>
                                <div class="flex-1 w-full">
                                    <input type="file" name="dokumen_file[]" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt" 
                                           class="w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                    <p class="text-[8px] text-gray-400 mt-1">PDF, Word, Excel, PPT (Max 10MB)</p>
                                </div>
                                <button type="button" onclick="removeDokumen(this)" class="btn-remove text-red-500 hover:text-red-700 flex-shrink-0">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Upload dokumen pendukung aset (PDF, Word, Excel, PPT, TXT).</p>
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
                                    <option value="Sewa" {{ old('skema') == 'Sewa' ? 'selected' : '' }}>Sewa</option>
                                    <option value="Kerjasama" {{ old('skema') == 'Kerjasama' ? 'selected' : '' }}>Kerjasama</option>
                                    <option value="Pemanfaatan" {{ old('skema') == 'Pemanfaatan' ? 'selected' : '' }}>Pemanfaatan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Tahun Perolehan</label>
                                <input type="number" name="tahun_perolehan" value="{{ old('tahun_perolehan') }}" placeholder="2025" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: GAMBAR -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="font-bold text-lg mb-4">Gambar Aset</h2>
                    
                    <!-- ========================================================= -->
                    <!-- DRAG & DROP UPLOAD -->
                    <!-- ========================================================= -->
                    <div class="drop-zone" id="dropZone">
                        <div class="icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <p class="text">Drag & drop gambar di sini</p>
                        <p class="hint">atau klik untuk memilih file</p>
                        <p class="hint" style="margin-top:0.5rem;color:#9ca3af;">
                            Format: JPG, PNG, GIF, WebP (Max 2MB)
                        </p>
                        <input type="file" id="gambarInput" name="gambar" 
                               accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                               style="display:none;">
                    </div>
                    
                    <!-- Preview -->
                    <div class="image-preview-container" id="imagePreviewContainer">
                        <div class="image-preview-wrapper">
                            <img id="previewImg" src="#" alt="Preview">
                            <button type="button" class="btn-remove-image" id="removeImage">
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="file-name" id="fileNameDisplay">Belum ada file</div>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div id="uploadProgress" style="display:none; margin-top:1rem;">
                        <div class="flex items-center gap-3">
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div id="progressBar" class="h-full bg-[#006400] transition-all duration-300" style="width:0%;"></div>
                            </div>
                            <span id="progressText" class="text-xs font-medium text-gray-500">0%</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Sedang mengupload...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- AKSI BAWAH -->
        <div class="mt-8 flex justify-end gap-4">
            <a href="{{ route('admin.aset.index') }}" class="border border-gray-300 rounded-lg px-6 py-3 text-sm font-medium hover:bg-gray-50 transition">Batal</a>
            <button type="submit" id="submitBtn" class="bg-[#006400] hover:bg-[#005500] text-white px-6 py-3 rounded-lg font-bold text-sm transition">
                <i class="fas fa-save mr-1.5"></i>
                <span id="submitText">Simpan Data</span>
                <span id="submitLoading" class="hidden">
                    <i class="fas fa-spinner fa-spin mr-1.5"></i>
                    Menyimpan...
                </span>
            </button>
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
    
    const latVal = parseFloat(document.getElementById('latInput').value);
    const lngVal = parseFloat(document.getElementById('lngInput').value);
    
    if (!isNaN(latVal) && !isNaN(lngVal) && latVal !== 0 && lngVal !== 0) {
        addMarker(latVal, lngVal);
        map.setView([latVal, lngVal], 12);
    }
    
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
    div.className = 'dokumen-item flex flex-col sm:flex-row items-start sm:items-center gap-3 p-3 bg-gray-50 rounded-lg mb-3';
    div.innerHTML = `
        <div class="flex-1 w-full">
            <input type="text" name="dokumen[]" placeholder="Nama dokumen..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div class="flex-1 w-full">
            <input type="file" name="dokumen_file[]" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt" 
                   class="w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
            <p class="text-[8px] text-gray-400 mt-1">PDF, Word, Excel, PPT (Max 10MB)</p>
        </div>
        <button type="button" onclick="removeDokumen(this)" class="btn-remove text-red-500 hover:text-red-700 flex-shrink-0">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(div);
}

function removeDokumen(button) {
    const container = document.getElementById('dokumenContainer');
    if (container.children.length > 1) {
        button.closest('.dokumen-item').remove();
    } else {
        alert('Minimal harus ada 1 dokumen.');
    }
}

// =========================================================
// DRAG & DROP UPLOAD (JAVASCRIPT)
// =========================================================
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('gambarInput');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const previewImg = document.getElementById('previewImg');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const removeBtn = document.getElementById('removeImage');
    const uploadProgress = document.getElementById('uploadProgress');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitLoading = document.getElementById('submitLoading');

    // =========================================================
    // KLIK UNTUK UPLOAD
    // =========================================================
    if (dropZone) {
        dropZone.addEventListener('click', function() {
            fileInput.click();
        });
    }

    // =========================================================
    // DRAG & DROP EVENTS
    // =========================================================
    if (dropZone) {
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFile(files[0]);
            }
        });
    }

    // =========================================================
    // FILE INPUT CHANGE
    // =========================================================
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                handleFile(this.files[0]);
            }
        });
    }

    // =========================================================
    // HANDLE FILE
    // =========================================================
    function handleFile(file) {
        // Validasi tipe file
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            showToast('Format file tidak didukung. Gunakan JPG, PNG, GIF, atau WebP.', 'error');
            fileInput.value = '';
            return;
        }

        // Validasi ukuran (2MB)
        if (file.size > 2 * 1024 * 1024) {
            showToast('Ukuran file terlalu besar. Maksimal 2MB.', 'error');
            fileInput.value = '';
            return;
        }

        // Tampilkan progress
        uploadProgress.style.display = 'block';
        progressBar.style.width = '0%';
        progressText.textContent = '0%';

        // Simulasi progress
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress >= 100) {
                progress = 100;
                clearInterval(interval);
                setTimeout(() => {
                    uploadProgress.style.display = 'none';
                }, 500);
            }
            progressBar.style.width = progress + '%';
            progressText.textContent = Math.round(progress) + '%';
        }, 200);

        // Preview gambar
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewContainer.classList.add('active');
            fileNameDisplay.textContent = file.name + ' (' + formatFileSize(file.size) + ')';
            
            // Update drop zone
            const textEl = dropZone.querySelector('.text');
            const iconEl = dropZone.querySelector('.icon i');
            if (textEl) {
                textEl.textContent = 'File siap diupload';
                textEl.style.color = '#006400';
            }
            if (iconEl) {
                iconEl.className = 'fas fa-check-circle';
                iconEl.style.color = '#006400';
            }
        };
        reader.readAsDataURL(file);
    }

    // =========================================================
    // REMOVE IMAGE
    // =========================================================
    if (removeBtn) {
        removeBtn.addEventListener('click', function() {
            resetUpload();
        });
    }

    function resetUpload() {
        fileInput.value = '';
        previewContainer.classList.remove('active');
        previewImg.src = '#';
        fileNameDisplay.textContent = 'Belum ada file';
        uploadProgress.style.display = 'none';
        progressBar.style.width = '0%';
        progressText.textContent = '0%';
        
        // Reset drop zone
        const textEl = dropZone.querySelector('.text');
        const iconEl = dropZone.querySelector('.icon i');
        if (textEl) {
            textEl.textContent = 'Drag & drop gambar di sini';
            textEl.style.color = '#6b7280';
        }
        if (iconEl) {
            iconEl.className = 'fas fa-cloud-upload-alt';
            iconEl.style.color = '#9ca3af';
        }
    }

    // =========================================================
    // HELPER: Format File Size
    // =========================================================
    function formatFileSize(bytes) {
        if (bytes >= 1048576) {
            return (bytes / 1048576).toFixed(1) + ' MB';
        }
        if (bytes >= 1024) {
            return (bytes / 1024).toFixed(1) + ' KB';
        }
        return bytes + ' B';
    }

    // =========================================================
    // TOAST NOTIFICATION
    // =========================================================
    function showToast(message, type = 'success') {
        // Cek apakah container sudah ada
        let container = document.getElementById('toastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'fixed top-20 right-4 z-[99999] space-y-3 max-w-sm w-full';
            document.body.appendChild(container);
        }

        const colors = {
            success: 'bg-green-50 border-green-400 text-green-800',
            error: 'bg-red-50 border-red-400 text-red-800',
            warning: 'bg-yellow-50 border-yellow-400 text-yellow-800',
            info: 'bg-blue-50 border-blue-400 text-blue-800'
        };
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-triangle-exclamation',
            info: 'fa-circle-info'
        };
        const typeKey = type || 'success';

        const toast = document.createElement('div');
        toast.className = `flex items-start gap-3 p-4 border rounded-xl shadow-lg ${colors[typeKey] || colors.success} animate-slide-in`;
        toast.innerHTML = `
            <i class="fas ${icons[typeKey] || icons.success} text-lg mt-0.5"></i>
            <div class="flex-1 text-sm font-medium">${message}</div>
            <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times"></i>
            </button>
        `;
        container.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100px)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }

    // =========================================================
    // KEYBOARD SHORTCUT: ESC untuk remove image
    // =========================================================
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && previewContainer && previewContainer.classList.contains('active')) {
            resetUpload();
        }
    });

    // =========================================================
    // LOADING STATE SAAT SUBMIT
    // =========================================================
    const form = document.getElementById('assetForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Cek apakah ada file yang sedang diproses
            const fileInput = document.getElementById('gambarInput');
            if (fileInput && fileInput.files.length > 0) {
                const file = fileInput.files[0];
                if (file.size > 2 * 1024 * 1024) {
                    e.preventDefault();
                    showToast('Ukuran file terlalu besar. Maksimal 2MB.', 'error');
                    return;
                }
            }

            // Tampilkan loading state
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-70', 'cursor-not-allowed');
                submitText.classList.add('hidden');
                submitLoading.classList.remove('hidden');
            }
        });
    }

    // =========================================================
    // INIT MAP
    // =========================================================
    initMap();
    
    // Enter key on lat/lng input to show location
    const latInput = document.getElementById('latInput');
    const lngInput = document.getElementById('lngInput');
    if (latInput) {
        latInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') showLocationOnMap();
        });
    }
    if (lngInput) {
        lngInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') showLocationOnMap();
        });
    }
});
</script>

@endsection