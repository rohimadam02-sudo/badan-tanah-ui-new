<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterSetting;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function index()
    {
        $footer = FooterSetting::getSettings();
        return view('admin.footer', compact('footer'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_website' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'alamat' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'footer_text' => 'nullable|string',
            'quick_links' => 'nullable|array',
            'quick_links.*.label' => 'required|string|max:255',
            'quick_links.*.url' => 'required|string|max:255',
        ]);

        $footer = FooterSetting::getSettings();

        $data = $request->except(['_token', 'quick_links']);
        $data['show_social_media'] = $request->has('show_social_media');
        $data['show_newsletter'] = $request->has('show_newsletter');

        // Proses quick links
        $quickLinks = [];
        if ($request->has('quick_links')) {
            foreach ($request->quick_links as $link) {
                if (!empty($link['label']) && !empty($link['url'])) {
                    $quickLinks[] = $link;
                }
            }
        }
        $data['quick_links'] = $quickLinks;

        $footer->update($data);

        // Log aktivitas
        activity()
            ->performedOn($footer)
            ->causedBy(auth()->user())
            ->event('updated')
            ->log('memperbarui footer');

        return redirect()
            ->route('admin.footer.index')
            ->with('success', 'Footer berhasil diperbarui!');
    }
}