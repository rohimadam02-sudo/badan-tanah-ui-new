<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuNavigasi;
use Illuminate\Http\Request;

class MenuNavigasiController extends Controller
{
    public function index()
    {
        $menu = MenuNavigasi::all();
        return view('admin.menu_navigasi', compact('menu'));
    }

    public function update(Request $request)
    {
        // Simpan perubahan status
        if ($request->has('menu')) {
            foreach ($request->menu as $id => $data) {
                $menuItem = MenuNavigasi::find($id);
                if ($menuItem) {
                    $menuItem->status = $data['status'];
                    $menuItem->save();
                }
            }
        }

        return redirect()->route('admin.menu_navigasi')->with('success', 'Menu navigasi berhasil diubah!');
    }
}