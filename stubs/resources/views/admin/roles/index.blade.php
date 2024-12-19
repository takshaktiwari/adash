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
                                <x-admin.btns.action-edit permission="roles_update" :url="route('admin.roles.edit', [$role])" />

                                <x-admin.btns.action-delete permission="roles_delete" :url="route('admin.roles.destroy', [$role])" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-admin.layout>
