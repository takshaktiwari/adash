<?php

namespace Takshak\Adash\Traits\Controllers\Admin;

use Illuminate\Http\Request;
use Takshak\Adash\Models\Setting;

trait SettingTrait
{
    public function index(Request $request)
    {
        $settings = Setting::get();
        return view('admin.settings.index', [
            'settings' => $settings
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.settings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'setting_key' => 'required',
            'setting_value' => 'nullable',
            'remarks' => 'nullable|max:255',
        ]);

        if ($request->file('setting_value')) {
            $setting_value = $request->file('setting_value')->storeAs(
                'settings',
                str()->of(microtime())->slug('-')
                    ->append('.')
                    ->append($request->file('setting_value')->extension()),
                'public'
            );
            $setting_value = storage($setting_value);
        } else {
            $setting_value = $request->post('setting_value');
        }

        Setting::updateOrCreate(
            [
                'title' => $request->post('title'),
                'setting_key' => str()->of($request->post('setting_key'))->slug('_'),
            ],
            [
                'setting_value' => $setting_value,
                'remarks' => $request->post('remarks'),
            ]
        );
        cache()->forget('settings');

        return redirect()->route('admin.settings.index')->withSuccess('SUCCESS !! Setting has been updated.');
    }

    public function edit(Setting $setting, Request $request)
    {
        return view('admin.settings.edit', [
            'setting' => $setting
        ]);
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();
        cache()->forget('settings');
        return redirect()->route('admin.settings.index')->withSuccess('SUCCESS !! Setting has been deleted.');
    }
}
