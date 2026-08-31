<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.user_index', compact('users'));
    }

    public function create()
    {
        return view('admin.user_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:super_admin,admin,editor,publisher',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->all();

        // Upload foto
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $file = $request->file('foto');
            $filename = 'user_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $data['foto'] = $file->storeAs('users', $filename, 'public');
        }

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
            'foto' => $data['foto'] ?? null,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user_edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:super_admin,admin,editor,publisher',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Upload foto baru
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            // Hapus foto lama jika ada
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $file = $request->file('foto');
            $filename = 'user_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $data['foto'] = $file->storeAs('users', $filename, 'public');
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diupdate!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Hapus foto
        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }
        
        $user->delete();
        
        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus!');
    }

    public function quickUpdateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'role' => 'required|in:super_admin,admin,editor,publisher',
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'Role user berhasil diubah!');
    }
}