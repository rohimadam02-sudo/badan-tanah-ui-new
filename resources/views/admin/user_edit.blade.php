@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Pengguna</h1>
        <a href="{{ route('admin.user.index') }}" class="text-sm text-gray-600 hover:text-[#006400]">Kembali ke Daftar</a>
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

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Foto -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Foto Profil</label>
                    <div class="flex items-center gap-4">
                        <div id="fotoPreview" class="w-20 h-20 rounded-full bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden">
                            @if ($user->foto)
                                <img src="{{ asset('storage/' . $user->foto) }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user text-2xl text-gray-400"></i>
                            @endif
                        </div>
                        <div>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-[#006400] transition cursor-pointer"
                                 onclick="document.getElementById('fotoInput').click()">
                                <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-1"></i>
                                <p class="text-sm font-medium text-gray-600">Upload foto</p>
                                <p class="text-xs text-gray-400">Format: JPG, PNG (Max 2MB)</p>
                                <input type="file" id="fotoInput" name="foto" accept="image/jpeg,image/png,image/jpg"
                                       class="hidden" onchange="previewFoto(event)">
                                <p id="fotoName" class="text-xs text-[#006400] mt-1">Belum ada file</p>
                            </div>
                            @if ($user->foto)
                                <p class="text-xs text-gray-400 mt-1">Foto saat ini: {{ basename($user->foto) }}</p>
                            @endif
                        </div>
                    </div>
                    @error('foto')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition" required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition" required>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password (Opsional)</label>
                    <input type="password" name="password" 
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition" 
                        placeholder="Kosongkan jika tidak diubah">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah password</p>
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Role <span class="text-red-500">*</span></label>
                    <select name="role" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#006400]/30 focus:border-[#006400] transition" required>
                        <option value="super_admin" {{ $user->role == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="publisher" {{ $user->role == 'publisher' ? 'selected' : '' }}>Publisher</option>
                        <option value="editor" {{ $user->role == 'editor' ? 'selected' : '' }}>Editor</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-[#006400] hover:bg-[#005500] text-white px-6 py-3 rounded-xl font-bold text-sm transition shadow-md hover:shadow-lg">
                    <i class="fas fa-save mr-1.5"></i>
                    Update Pengguna
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewFoto(event) {
        const input = event.target;
        const preview = document.getElementById('fotoPreview');
        const nameDisplay = document.getElementById('fotoName');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            nameDisplay.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            }
            reader.readAsDataURL(file);
        }
    }
</script>

@endsection