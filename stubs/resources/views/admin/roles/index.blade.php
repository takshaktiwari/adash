<x-admin.layout>
	<x-admin.breadcrumb 
		title='Roles'
		:links="[
			['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
            ['text' => 'Roles'],
		]"
        :actions="[
            ['text' => 'New Role', 'icon' => 'fas fa-plus', 'url' => route('admin.roles.create'), 'permission' => 'roles_create', 'class' => 'btn-success btn-loader'],
            ['text' => 'Dashboard', 'icon' => 'fas fa-technometer', 'url' => auth()->user()->dashboardRoute(), 'class' => 'btn-dark btn-loader'],
        ]" />
	
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table mb-0">
                <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach($roles as $key => $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @can('roles_update')
                                <a href="{{ route('admin.roles.edit', [$role]) }}" class="btn btn-sm btn-success btn-loader load-circle">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan

                                @can('roles_delete')
                                <form action="{{ route('admin.roles.destroy', [$role]) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger delete-alert btn-loader load-circle">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>        
        </div>
    </div>
    
</x-admin.layout>
