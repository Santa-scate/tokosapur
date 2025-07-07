<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Ambil semua settings, ubah menjadi array asosiatif 'key' => 'value'
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Validasi bisa ditambahkan di sini jika perlu
        $settings = $request->except('_token');

        foreach ($settings as $key => $value) {
            // Gunakan updateOrCreate untuk membuat atau mengupdate setting
            Setting::updateOrCreate(
                ['key' => $key], // Cari berdasarkan key
                ['value' => $value] // Update atau buat dengan value ini
            );
            Cache::forget('setting_' . $key);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}


