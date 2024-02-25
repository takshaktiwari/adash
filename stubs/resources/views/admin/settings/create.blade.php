<x-admin.layout>
    <x-admin.breadcrumb title='New Settings' :links="[
        ['text' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['text' => 'Settings', 'url' => route('admin.settings.index')],
        ['text' => 'Create'],
    ]" :actions="[
        [
            'text' => 'All Settings',
            'icon' => 'fas fa-list',
            'url' => route('admin.settings.index'),
            'class' => 'btn-success btn-loader',
            'permission' => 'settings_access'
        ],
    ]" />

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('admin.settings.store') }}" method="POST" class="card" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Name*</label>
                                <input type="text" class="form-control" name="title" required
                                    placeholder="Setting name / title">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Setting key*</label>
                                <input type="text" class="form-control" name="setting_key" required
                                    placeholder="Setting name / title">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Setting value*</label>
                        <div class="d-flex">
                            <input type="text" class="form-control" name="setting_value" id="setting_value" required
                                placeholder="Setting name / title">
                            <div class="form-check my-auto ps-4 ms-3">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="is_file" value="1">
                                    <span class="text-nowrap">Is file</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Remarks</label>
                        <textarea name="remarks" id="remarks" rows="2" class="form-control"></textarea>
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
