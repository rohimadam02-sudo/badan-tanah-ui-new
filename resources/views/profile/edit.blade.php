<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Informasi Profil
                    </h3>
                    
                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div>
                            <x-input-label for="name" :value="__('Nama')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                                :value="old('name', $user->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" 
                                :value="old('email', $user->email)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="foto" :value="__('Foto Profil')" />
                            
                            @if($user->foto)
                                <div class="mt-2 mb-3">
                                    <img src="{{ asset('storage/' . $user->foto) }}" 
                                         class="w-20 h-20 rounded-full object-cover border-2 border-gray-200" 
                                         alt="Foto Profil">
                                </div>
                            @endif
                            
                            <input type="file" name="foto" id="foto" 
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
                                   accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                            <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG (Max 2MB)</p>
                            <x-input-error class="mt-2" :messages="$errors->get('foto')" />
                        </div>

                        <div class="mt-3 flex items-center gap-2">
                            <input type="checkbox" name="hapus_foto" id="hapus_foto" value="1"
                                   class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                            <label for="hapus_foto" class="text-sm text-red-600">Hapus foto profil</label>
                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

                            @if (session('status') === 'profile-updated')
                                <p class="text-sm text-green-600">✅ Profil berhasil diperbarui!</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Ubah Password
                    </h3>
                    
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div>
                            <x-input-label for="update_password_current_password" :value="__('Password Saat Ini')" />
                            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="update_password_password" :value="__('Password Baru')" />
                            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Password Baru')" />
                            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>{{ __('Simpan Password') }}</x-primary-button>

                            @if (session('status') === 'password-updated')
                                <p class="text-sm text-green-600">✅ Password berhasil diubah!</p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            @if(auth()->user()->role == 'super_admin')
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-red-600 dark:text-red-400 mb-4">
                        ⚠️ Hapus Akun
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Setelah akun dihapus, semua data akan hilang permanen.
                    </p>
                    <button type="button" 
                            onclick="confirm('Apakah Anda yakin ingin menghapus akun ini?') && document.getElementById('deleteAccountForm').submit()"
                            class="mt-4 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium text-sm transition">
                        Hapus Akun
                    </button>
                    <form id="deleteAccountForm" method="post" action="{{ route('profile.destroy') }}" class="hidden">
                        @csrf
                        @method('delete')
                    </form>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
