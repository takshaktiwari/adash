<x-admin.layout>
	<x-admin.breadcrumb
			title='All Users'
			:links="[
				['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
                ['text' => 'Users']
			]"
            :actions="[
                ['text' => 'Filter', 'icon' => 'fas fa-filter', 'class' => 'btn-secondary btn-loader', 'url' => route('admin.users.index', ['filter' => 1]) ],
                ['text' => 'Create New', 'permission' => 'users_create', 'icon' => 'fas fa-plus', 'url' => route('admin.users.create'), 'class' => 'btn-dark btn-loader'],
            ]"
		/>

    @if(request()->get('filter'))
    <div class="card" id="filter">
        <div class="card-body">
            <form action="">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <input type="text" name="search" class="form-control mb-sm-0 mb-2" placeholder="Search" value="{{ Request::get('search') }}">
                    </div>
                    <div class="col-12 col-md-3">
                        <select name="role_id" required="" class="form-control">
                            <option value="">-- Select Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <button type="submit" class="btn btn-dark btn-loader">
                            <i class="fas fa-save"></i> Submit
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-basic border btn-loader">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

    <div class="card shadow-sm">
        <x-admin.paginator-info :items="$users" class="card-header" />
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Role</th>
                        <th>Verified</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $user->name }}

                                <a href="{{ route('admin.users.status-toggle', [$user]) }}" class="badge bg-{{ $user->status ? 'success' : 'danger' }} fs-12">
                                    {{ $user->status ? 'Active' : 'In-active' }}
                                </a>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                            <td>{{ $user->email_verified_at ? date('d-M-y h:i A', strtotime($user->email_verified_at)) : '' }}</td>
                            <td>
                                @can('users_show')
                                <a href="{{ route('admin.users.show', [$user]) }}" class="btn btn-info btn-sm btn-loader load-circle">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                @endcan

                                @can('users_update')
                                <a href="{{ route('admin.users.edit', [$user]) }}" class="btn btn-success btn-sm btn-loader load-circle">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan

                                @can('users_delete')
                                    @if($user->id != 1)
                                        <form action="{{ route('admin.users.destroy', [$user]) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger delete-alert btn-loader load-circle"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>
</x-admin.layout>
