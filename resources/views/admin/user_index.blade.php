@extends('layouts.admin')

@section('title', 'Daftar Pengguna')

@section('content')

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Daftar Pengguna</h1>
        <p class="text-sm text-gray-500 mt-1">Manajemen akun dan akses pengguna ke CMS.</p>
    </div>
    <a href="{{ route('admin.user.create') }}" class="bg-[#006400] hover:bg-[#005500] text-white px-5 py-2.5 rounded font-semibold text-sm">
        <i class="fas fa-plus mr-1.5"></i>
        Tambah Pengguna
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 border-b-2 border-gray-200">
                <tr>
                    <th class="px-6 py-3 font-semibold text-gray-700">Foto</th>
                    <th class="px-6 py-3 font-semibold text-gray-700">Nama</th>
                    <th class="px-6 py-3 font-semibold text-gray-700">Email</th>
                    <th class="px-6 py-3 font-semibold text-gray-700">Role</th>
                    <th class="px-6 py-3 font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        @if ($user->foto)
                            <img src="{{ asset('storage/' . $user->foto) }}" 
                                class="w-10 h-10 rounded-full object-cover border border-gray-200">
                        @else
                            <div class="w-10 h-10 bg-[#006400] rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <span class="font-medium text-gray-900">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold
                            {{ $user->role == 'super_admin' ? 'bg-purple-50 text-purple-700' :
                               ($user->role == 'admin' ? 'bg-blue-50 text-blue-700' :
                               ($user->role == 'editor' ? 'bg-yellow-50 text-yellow-700' :
                               ($user->role == 'publisher' ? 'bg-green-50 text-green-700' :
                               'bg-gray-50 text-gray-500'))) }}">
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <!-- Update Role -->
                            @if (auth()->user()->role == 'super_admin')
                                <form action="{{ route('admin.user.quickUpdateRole', $user->id) }}" method="POST" class="inline-flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" class="border border-gray-300 rounded px-2 py-1 text-xs" onchange="this.form.submit()">
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="editor" {{ $user->role == 'editor' ? 'selected' : '' }}>Editor</option>
                                        <option value="publisher" {{ $user->role == 'publisher' ? 'selected' : '' }}>Publisher</option>
                                        <option value="super_admin" {{ $user->role == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                    </select>
                                </form>
                            @endif
                            
                            <a href="{{ route('admin.user.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-bold">Edit</a>
                            
                            @if (auth()->user()->role == 'super_admin' && $user->id != auth()->id())
                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-bold">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection