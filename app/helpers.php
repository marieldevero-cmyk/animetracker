<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('storage_asset')) {
    function storage_asset(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        $disk = config('filesystems.cloud_images', 'public');

        return Storage::disk($disk)->url($path);
    }
}
