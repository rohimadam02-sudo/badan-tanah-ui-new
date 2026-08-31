<?php $__env->startSection('title', 'Tambah Aset Baru'); ?>

<?php $__env->startSection('content'); ?>

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
    .dokumen-item .btn-remove {
        color: #ef4444;
        background: none;
        border: none;
        cursor: pointer;
    }
</style>

<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Aset Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Lengkapi informasi aset tanah untuk proses verifikasi.</p>
        </div>
        <a href="<?php echo e(route('admin.aset.index')); ?>" class="text-sm text-gray-600 hover:text-[#006400]">Kembali ke Daftar</a>
    </div>

    <form action="<?php echo e(route('admin.aset.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        
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
                                <input type="text" name="nama_lokasi" value="<?php echo e(old('nama_lokasi')); ?>" class="w-full border-gray-300 rounded-lg p-3 text-sm focus:ring-[#006400]" required>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Kategori Aset <span class="text-red-500">*</span></label>
                                    <select name="peruntukan" class="w-full border-gray-300 rounded-lg p-3 text-sm" required>
                                        <option value="">Pilih kategori</option>
                                        <option value="Industri">Industri</option>
                                        <option value="Pertanian">Pertanian</option>
                                        <option value="Perumahan">Perumahan</option>
                                        <option value="Komersial">Komersial</option>
                                        <option value="Sosial">Sosial</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Status Aset <span class="text-red-500">*</span></label>
                                    <select name="status" class="w-full border-gray-300 rounded-lg p-3 text-sm" required>
                                        <option value="Tersedia">Tersedia</option>
                                        <option value="Dalam Pengembangan">Dalam Pengembangan</option>
                                        <option value="Dalam Proses">Dalam Proses</option>
                                        <option value="Terikat">Terikat</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Luas Tanah (Ha) <span class="text-red-500">*</span></label>
                                    <input type="number" step="0.01" name="luas_hektar" value="<?php echo e(old('luas_hektar')); ?>" class="w-full border-gray-300 rounded-lg p-3 text-sm" placeholder="Contoh: 2450.00" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Skema</label>
                                    <select name="skema" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                                        <option value="">Pilih skema</option>
                                        <option value="Sewa">Sewa</option>
                                        <option value="Kerjasama">Kerjasama</option>
                                        <option value="Pemanfaatan">Pemanfaatan</option>
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
                                    <input type="text" name="provinsi" value="<?php echo e(old('provinsi')); ?>" class="w-full border-gray-300 rounded-lg p-3 text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Kabupaten <span class="text-red-500">*</span></label>
                                    <input type="text" name="kabupaten" value="<?php echo e(old('kabupaten')); ?>" class="w-full border-gray-300 rounded-lg p-3 text-sm" required>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Latitude</label>
                                    <input type="number" step="0.0000001" name="lat" id="latInput" value="<?php echo e(old('lat')); ?>" class="w-full border-gray-300 rounded-lg p-3 text-sm" placeholder="-6.7825">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold mb-1">Longitude</label>
                                    <input type="number" step="0.0000001" name="lng" id="lngInput" value="<?php echo e(old('lng')); ?>" class="w-full border-gray-300 rounded-lg p-3 text-sm" placeholder="106.7825">
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
                        </div>
                    </div>
                </div>

                <!-- TAB 3: DETAIL ASET -->
                <div id="tab-content-detail" class="tab-section">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="font-bold text-lg mb-4">Detail Aset</h2>
                        
                        <div>
                            <label class="block text-sm font-semibold mb-1">Deskripsi Aset</label>
                            <textarea name="deskripsi" rows="6" class="w-full border-gray-300 rounded-lg p-3 text-sm"><?php echo e(old('deskripsi')); ?></textarea>
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
                                    <option value="Pembelian">Pembelian</option>
                                    <option value="Sewa">Sewa</option>
                                    <option value="Hibah">Hibah</option>
                                    <option value="Tukar Menukar">Tukar Menukar</option>
                                    <option value="Lelang">Lelang</option>
                                    <option value="Pengadaan">Pengadaan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Nilai Perkiraan</label>
                                <input type="text" name="nilai_perkiraan" placeholder="Rp" class="w-full border-gray-300 rounded-lg p-3 text-sm">
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
                            <?php if(old('dokumen')): ?>
                                <?php $__currentLoopData = old('dokumen'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dok): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="dokumen-item">
                                        <input type="text" name="dokumen[]" value="<?php echo e($dok); ?>" placeholder="Nama dokumen..." class="flex-1 border-gray-300 rounded-lg p-2 text-sm">
                                        <button type="button" onclick="removeDokumen(this)" class="btn-remove"><i class="fas fa-times"></i></button>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="dokumen-item">
                                    <input type="text" name="dokumen[]" placeholder="Nama dokumen..." class="flex-1 border-gray-300 rounded-lg p-2 text-sm">
                                    <button type="button" onclick="removeDokumen(this)" class="btn-remove"><i class="fas fa-times"></i></button>
                                </div>
                            <?php endif; ?>
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
                                    <option value="Sewa">Sewa</option>
                                    <option value="Kerjasama">Kerjasama</option>
                                    <option value="Pemanfaatan">Pemanfaatan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-1">Tahun Perolehan</label>
                                <input type="number" name="tahun_perolehan" placeholder="2025" class="w-full border-gray-300 rounded-lg p-3 text-sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: GAMBAR -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="font-bold text-lg mb-4">Gambar Aset</h2>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center mb-4 hover:border-[#006400] transition cursor-pointer"
                         onclick="document.getElementById('gambarInput').click()">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                        <p class="text-sm font-medium text-gray-600">Drag & drop gambar atau klik untuk upload</p>
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
            <a href="<?php echo e(route('admin.aset.index')); ?>" class="border border-gray-300 rounded-lg px-6 py-3 text-sm font-medium hover:bg-gray-50 transition">Batal</a>
            <button type="submit" class="bg-[#006400] hover:bg-[#005500] text-white px-6 py-3 rounded-lg font-bold text-sm transition">Simpan Data</button>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\rohim\badan-tanah-ui-new\resources\views/admin/aset_create.blade.php ENDPATH**/ ?>