<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('storage_asset')) {
    function storage_asset(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        $disk = config('filesystems.cloud_images', 'public');

        if ($disk === 'public') {
            return '/storage/' . ltrim($path, '/');
        }

        return Storage::disk($disk)->url($path);
    }
}
