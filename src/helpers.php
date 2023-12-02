<?php

use Takshak\Adash\Models\Setting;

if (!function_exists('storage')) {
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

if (!function_exists('setting')) {
    function setting(string|array $key, string|array $default = null, bool $onlyValue = true)
    {
        $settings = cache()->rememberForever('settings', function () {
            return Setting::get();
        });

        if (is_string($key)) {
            $setting = $settings->where('setting_key', $key)->first();
            $returningValue = $onlyValue ? $setting?->setting_value : $setting;
        } else {
            $settings = $settings->whereIn('setting_key', $key);
            $returningValue = $onlyValue ? $settings?->pluck('setting_value') : $settings;
        }

        return $returningValue ? $returningValue : $default;
    }
}
