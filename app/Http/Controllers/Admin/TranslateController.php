<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\KimiService;
use Illuminate\Http\Request;

class TranslateController extends Controller
{
    protected $kimi;

    public function __construct(KimiService $kimi)
    {
        $this->kimi = $kimi;
    }

    /**
     * Translate content using Kimi K2.5
     */
    public function translate(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:5000',
            'type' => 'nullable|string|in:berita,halaman',
        ]);

        $text = $request->input('text');

        if (empty($text)) {
            return response()->json([
                'success' => false,
                'message' => 'Text is required',
            ], 400);
        }

        // Cek apakah API key terkonfigurasi
        if (!$this->kimi->isConfigured()) {
            return response()->json([
                'success' => false,
                'message' => 'Kimi API key not configured. Please add KIMI_API_KEY to .env file.',
            ], 400);
        }

        try {
            $translated = $this->kimi->translateToEnglish($text);

            return response()->json([
                'success' => true,
                'original' => $text,
                'translated' => $translated,
                'message' => 'Terjemahan berhasil!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjemahan gagal: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check if Kimi API is configured
     */
    public function status()
    {
        return response()->json([
            'configured' => $this->kimi->isConfigured(),
        ]);
    }
}