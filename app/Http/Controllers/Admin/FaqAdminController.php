<?php

/* =========================================================
    NAMESPACE & IMPORT
========================================================= */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

/* =========================================================
    CONTROLLER: FAQ ADMIN
========================================================= */
class FaqAdminController extends Controller
{
    /* =========================================================
        DAFTAR FAQ
    ========================================================= */
    public function index()
    {
        $faqs = Faq::all();
        return view('admin.faq_index', compact('faqs'));
    }

    /* =========================================================
        FORM TAMBAH FAQ
    ========================================================= */
    public function create()
    {
        return view('admin.faq_create');
    }

    /* =========================================================
        SIMPAN FAQ BARU
    ========================================================= */
    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'jawaban' => 'required|string',
        ]);

        Faq::create([
            'pertanyaan' => $request->pertanyaan,
            'kategori' => $request->kategori,
            'jawaban' => $request->jawaban,
        ]);

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil ditambahkan!');
    }

    /* =========================================================
        FORM EDIT FAQ
    ========================================================= */
    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.faq_edit', compact('faq'));
    }

    /* =========================================================
        UPDATE FAQ
    ========================================================= */
    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'jawaban' => 'required|string',
        ]);

        $faq->update([
            'pertanyaan' => $request->pertanyaan,
            'kategori' => $request->kategori,
            'jawaban' => $request->jawaban,
        ]);

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil diperbarui!');
    }

    /* =========================================================
        HAPUS FAQ
    ========================================================= */
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil dihapus!');
    }
}