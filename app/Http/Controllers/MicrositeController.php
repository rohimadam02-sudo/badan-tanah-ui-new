<?php

namespace App\Http\Controllers;

use App\Models\Microsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MicrositeController extends Controller
{
    /**
     * Display microsite frontend
     */
    public function show($slug)
    {
        $microsite = Microsite::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Increment views
        $microsite->increment('views');

        return view('frontend.microsite', compact('microsite'));
    }

    /**
     * Display list of all microsites (optional)
     */
    public function index()
    {
        $microsites = Microsite::where('is_active', true)
            ->latest()
            ->get();

        return view('frontend.microsite_list', compact('microsites'));
    }
}