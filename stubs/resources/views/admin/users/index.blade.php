<x-admin.layout>
    <x-admin.breadcrumb title='All Users' :links="[['text' => 'Dashboard', 'url' => route('admin.dashboard')], ['text' => 'Users']]" :actions="[
        [
            'text' => 'Filter',
            'icon' => 'fas fa-filter',
            'class' => 'btn-secondary btn-loader',
            'url' => route('admin.users.index', ['filter' => 1]),
        ],
        [
            'text' => 'Create New',
            'permission' => 'users_create',
            'icon' => 'fas fa-plus',
            'url' => route('admin.users.create'),
            'class' => 'btn-dark btn-loader',
        ],
    ]" />

    @if (request('filter'))
        <form class="card" id="filter">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-4 col-sm-6">
                        <input type="text" name="search" class="form-control mb-sm-0 mb-2" placeholder="Search"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-12 col-md-4 col-sm-6">
                        <select name="role_id" class="form-control">
                            <option value="">-- Select Role --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-dark btn-loader px-3" name="filter" value="1">
                    <i class="fas fa-save"></i> Submit
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-danger btn-loader px-3">
                    <i class="fas fa-times"></i> Reset
                </a>
            </div>
        </form>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            {{ $dataTable->table() }}
        </div>
    </div>

    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
</x-admin.layout>
