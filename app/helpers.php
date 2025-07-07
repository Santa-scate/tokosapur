<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('setting')) {
    /**
     * Mengambil nilai dari tabel settings.
     * Menggunakan cache untuk performa.
     */
    function setting($key, $default = null)
    {
        // Ambil dari cache, atau jika tidak ada, jalankan query lalu simpan ke cache
        return Cache::rememberForever('setting_' . $key, function () use ($key, $default) {
            $setting = Setting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }
}

