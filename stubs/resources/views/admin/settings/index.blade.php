<x-admin.layout>
    <x-admin.breadcrumb title='Settings' :links="[['text' => 'Dashboard', 'url' => route('admin.dashboard')], ['text' => 'Settings']]" :actions="[
        [
            'text' => 'New Setting',
            'icon' => 'fas fa-plus',
            'url' => route('admin.settings.create'),
            'class' => 'btn-success btn-loader',
            'permission' => 'settings_create',
        ],
    ]" />

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table">
                <thead>
                    <th>Name</th>
                    <th>Value</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($settings as $setting)
                        <tr>
                            <td>
                                <span class="text-nowrap">{{ $setting->title }}</span>
                                <span class="d-block small">{{ $setting->setting_key }}</span>
                            </td>
                            <td>
                                @if (is_array(setting($setting->setting_key)))
                                    <div class="d-flex flex-wrap rounded">
                                        @foreach (setting($setting->setting_key) as $key => $value)
                                            <div class="p-2 border border-dark">
                                                <b>{{ $key }}: </b>
                                                @if (is_array($value))
                                                    <ul class="mb-0">
                                                        @foreach ($value as $k => $val)
                                                            <li>
                                                                <b>{{ $k }}: </b>
                                                                @if ($k == 'color')
                                                                    <span class="d-inline-block border border-dark"
                                                                        style="width: 50px; height: 10px; background-color: {{ $val }}"></span>
                                                                @else
                                                                    {{ $val }}
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    @if ($key == 'color')
                                                        <span class="d-inline-block border border-dark"
                                                            style="width: 50px; height: 10px; background-color: {{ $value }}"></span>
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    {{ $setting->setting_value }}
                                @endif
                                <em class="d-block small">{{ $setting->remarks }}</em>
                            </td>
                            <td class="text-nowrap">
                                <x-admin.btns.action-edit permission="settings_update" :url="route('admin.settings.edit', [$setting])" />

                                @if (!$setting->protected)
                                    <x-admin.btns.action-delete permission="settings_delete" :url="route('admin.settings.destroy', [$setting])" />
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin.layout>
