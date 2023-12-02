<x-admin.layout>
    @push('styles')
        <style>
            input[type=color]{
                padding: 0.15rem;
            }
        </style>
    @endpush
    <x-admin.breadcrumb title='Edit Settings' :links="[
        ['text' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['text' => 'Settings', 'url' => route('admin.settings.index')],
        ['text' => 'Edit'],
    ]" :actions="[
        [
            'text' => 'All Settings',
            'icon' => 'fas fa-list',
            'url' => route('admin.settings.index'),
            'class' => 'btn-success btn-loader',
        ],
    ]" />

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('admin.settings.store') }}" method="POST" class="card shadow-sm" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Name*</label>
                                <input type="text" class="form-control" name="title" value="{{ $setting->title }}"
                                    required placeholder="Setting name / title">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Setting key*</label>
                                <input type="text" class="form-control" name="setting_key"
                                    value="{{ $setting->setting_key }}" required placeholder="Setting name / title">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Setting value*</label>
                        @if (is_array(setting($setting->setting_key)))
                            @foreach (setting($setting->setting_key) as $key => $value)
                                <div class="form-group">
                                    <label>{{ $key }}: </label>
                                    @if (is_array($value))
                                        @foreach ($value as $k => $val)
                                            <div class="ms-3 mb-1">
                                                <b class="text-info">{{ $k }}:</b>
                                                <input type="{{ ($k == 'color') ? 'color' : 'text' }}"
                                                    name="setting_value[{{ $key }}][{{ $k }}]"
                                                    class="form-control" value="{{ $val }}">
                                            </div>
                                        @endforeach
                                    @else
                                        <input type="{{ ($key == 'color') ? 'color' : 'text' }}" name="setting_value[{{ $key }}]"
                                            class="form-control" value="{{ $value }}">
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="d-flex">
                                <input type="text" class="form-control" name="setting_value"
                                    value="{{ $setting->setting_value }}" id="setting_value" required
                                    placeholder="Setting name / title">
                                <div class="form-check my-auto ps-4 ms-3">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" id="is_file" value="1">
                                        <span class="text-nowrap">Is file</span>
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="">Remarks</label>
                        <textarea name="remarks" id="remarks" rows="2" class="form-control">{{ $setting->remarks }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-dark px-3">
                        <i class="fas fa-save"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $("#is_file").change(function() {
                    $("#setting_value").attr('type', $(this).is(":checked") ? 'file' : 'text');
                });
            });
        </script>
    @endpush
</x-admin.layout>
