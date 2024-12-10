<?php

namespace Takshak\Adash\Traits\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Takshak\Adash\Models\Setting;

trait SettingTrait
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $this->authorize('settings_access');
        $settings = Setting::get();
        return view('admin.settings.index', [
            'settings' => $settings
        ]);
    }

    public function create(Request $request)
    {
        $this->authorize('settings_create');
        return view('admin.settings.create');
    }

    public function store(Request $request)
    {
        abort_if(
            !Gate::check(['settings_create', 'settings_update']),
            403,
            'THIS ACTION IS UNAUTHORIZED.'
        );

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
        $this->authorize('settings_update');
        return view('admin.settings.edit', [
            'setting' => $setting
        ]);
    }

    public function destroy(Setting $setting)
    {
        $this->authorize('settings_delete');
        $setting->delete();
        cache()->forget('settings');
        return redirect()->route('admin.settings.index')->withSuccess('SUCCESS !! Setting has been deleted.');
    }
}
