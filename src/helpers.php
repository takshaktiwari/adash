<?php

use Illuminate\Support\Str;

if (!function_exists('storage_url')) {
    function storage($append = null)
    {
        $storageUrl = env('STORAGE_URL') ? env('STORAGE_URL') : asset('storage');
        if ($append) {
            $storageUrl .= (substr($storageUrl, -1) == '/') ? '' : '/';

            $append     = ltrim($append, '/');
            $storageUrl .= $append;
        }
        return $storageUrl;
    }
}
