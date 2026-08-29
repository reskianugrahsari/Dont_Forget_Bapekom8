<?php

declare(strict_types=1);

use App\Http\Controllers\PengajuanController;
use App\Models\PwaSetting;
use Illuminate\Support\Facades\Route;

Route::get('/', [PengajuanController::class, 'index'])->name('pengajuan.index');
Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
Route::get('/manifest.webmanifest', function () {
    $setting = PwaSetting::query()->first();

    $icon192 = $setting?->icon_192 ? asset('storage/'.$setting->icon_192) : asset('images/pwa/icon-192.png');
    $icon512 = $setting?->icon_512 ? asset('storage/'.$setting->icon_512) : asset('images/pwa/icon-512.png');

    return response()->json([
        'name' => $setting?->app_name ?? "DON'T FORGET",
        'short_name' => $setting?->short_name ?? "DON'T FORGET",
        'description' => $setting?->description ?? 'Sistem pengajuan lupa absen dan tata usaha',
        'start_url' => $setting?->start_url ?? '/',
        'scope' => $setting?->scope ?? '/',
        'display' => $setting?->display ?? 'standalone',
        'theme_color' => $setting?->theme_color ?? '#111827',
        'background_color' => $setting?->background_color ?? '#ffffff',
        'icons' => [
            [
                'src' => $icon192,
                'sizes' => '192x192',
                'type' => 'image/png',
            ],
            [
                'src' => $icon512,
                'sizes' => '512x512',
                'type' => 'image/png',
            ],
        ],
    ]);
})->name('pwa.manifest');

Route::get('/sw.js', function () {
    $setting = PwaSetting::query()->first();
    $cacheVersion = $setting?->cache_version ?? 'v1';
    $offlineEnabled = $setting?->offline_enabled ?? true;

    $content = "const CACHE_VERSION = '{$cacheVersion}';\nconst CACHE_NAME = `dont-forget-${cacheVersion}`;\nconst OFFLINE_ENABLED = ".($offlineEnabled ? 'true' : 'false').";\nconst ASSETS = ['/', '/manifest.webmanifest'];\nself.addEventListener('install', event => { event.waitUntil(caches.open(CACHE_NAME).then(cache => cache.addAll(ASSETS))); self.skipWaiting(); });\nself.addEventListener('activate', event => { event.waitUntil(caches.keys().then(keys => Promise.all(keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key))))); self.clients.claim(); });\nself.addEventListener('fetch', event => { if (!OFFLINE_ENABLED) return; if (event.request.method !== 'GET') return; event.respondWith(fetch(event.request).catch(() => caches.match(event.request).then(response => response || caches.match('/')))); });";

    return response($content, 200)->header('Content-Type', 'application/javascript');
})->name('pwa.sw');
