<?php

if (!function_exists('storage_url')) {
    function storage($append = null)
    {
        $storageUrl = '';
        if (env('STORAGE_URL')) {
            $storageUrl = env('STORAGE_URL');
        } elseif (env('ASSET_URL')) {
            $storageUrl = env('ASSET_URL');
        } else {
            $storageUrl = asset('storage');
        }

        if ($append) {
            $storageUrl .= (substr($storageUrl, -1) == '/') ? '' : '/';

            $append     = ltrim($append, '/');
            $storageUrl .= $append;
        }
        return $storageUrl;
    }
}
