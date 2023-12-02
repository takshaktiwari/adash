<x-admin.layout>
    <x-admin.breadcrumb title='Settings' :links="[['text' => 'Dashboard', 'url' => route('admin.dashboard')], ['text' => 'Settings']]" :actions="[
        [
            'text' => 'New Setting',
            'icon' => 'fas fa-plus',
            'url' => route('admin.settings.create'),
            'class' => 'btn-success btn-loader',
        ],
    ]" />

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table">
                <thead>
                    <th>Name</th>
                    <th>Value</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($settings as $setting)
                        <tr>
                            <td>
                                {{ $setting->title }}
                                <span class="d-block small">{{ $setting->setting_key }}</span>
                            </td>
                            <td>{{ $setting->setting_value }}</td>
                            <td>{{ $setting->remarks }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.settings.edit', [$setting]) }}"
                                    class="btn btn-sm btn-success btn-loader load-circle">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @if (!$setting->protected)
                                    <form action="{{ route('admin.settings.destroy', [$setting]) }}" method="POST"
                                        class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-danger delete-alert btn-loader load-circle">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin.layout>
