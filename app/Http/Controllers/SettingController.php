<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = $this->getSettings();
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'galeri_1_img' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'galeri_2_img' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'galeri_3_img' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'galeri_4_img' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'galeri_5_img' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'galeri_6_img' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $settings = $this->getSettings();

        // Banner image
        if ($request->hasFile('banner_image')) {
            if (isset($settings['banner_image']) && Storage::disk('public')->exists($settings['banner_image'])) {
                Storage::disk('public')->delete($settings['banner_image']);
            }
            $settings['banner_image'] = $request->file('banner_image')->store('settings', 'public');
        }

        // Profile image
        if ($request->hasFile('profile_image')) {
            if (isset($settings['profile_image']) && Storage::disk('public')->exists($settings['profile_image'])) {
                Storage::disk('public')->delete($settings['profile_image']);
            }
            $settings['profile_image'] = $request->file('profile_image')->store('settings', 'public');
        }

        // Gallery images
        for ($i = 1; $i <= 6; $i++) {
            $fieldName = 'galeri_' . $i . '_img';
            if ($request->hasFile($fieldName)) {
                if (isset($settings[$fieldName]) && Storage::disk('public')->exists($settings[$fieldName])) {
                    Storage::disk('public')->delete($settings[$fieldName]);
                }
                $settings[$fieldName] = $request->file($fieldName)->store('settings', 'public');
            }
        }

        // Text fields
        $textFields = [
            'fee_dokter_umum', 'fee_dokter_spesialis',
            'hero_title', 'hero_subtitle', 'hero_badge',
            'profile_subtitle', 'profile_title', 'profile_description',
            'stat_1_value', 'stat_1_label', 'stat_2_value', 'stat_2_label',
            'visi', 'motto',
            'misi_1_title', 'misi_1_desc', 'misi_2_title', 'misi_2_desc', 'misi_3_title', 'misi_3_desc',
            'layanan_1_icon', 'layanan_1_title', 'layanan_1_desc',
            'layanan_2_icon', 'layanan_2_title', 'layanan_2_desc',
            'layanan_3_icon', 'layanan_3_title', 'layanan_3_desc',
            'berita_1_title', 'berita_1_date', 'berita_1_desc', 'berita_1_img',
            'berita_2_title', 'berita_2_date', 'berita_2_desc', 'berita_2_img',
            'berita_3_title', 'berita_3_date', 'berita_3_desc', 'berita_3_img',
            'contact_address', 'contact_phone', 'contact_email',
            'social_facebook', 'social_instagram', 'social_youtube',
            'galeri_1_caption', 'galeri_2_caption', 'galeri_3_caption',
            'galeri_4_caption', 'galeri_5_caption', 'galeri_6_caption',
        ];

        foreach ($textFields as $field) {
            if ($request->has($field)) {
                $settings[$field] = $request->input($field);
            }
        }

        Storage::put('settings.json', json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->route('settings.index')->with('success', 'Pengaturan web berhasil diperbarui!');
    }

    private function getSettings(): array
    {
        $json = Storage::get('settings.json');
        return $json ? json_decode($json, true) : [];
    }
}
