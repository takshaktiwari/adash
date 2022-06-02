<x-admin.layout>
	<x-admin.breadcrumb
			title='User Detail'
			:links="[
				['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
                ['text' => 'Users', 'url' => route('admin.users.index')],
                ['text' =>  'Detail']
			]"
            :actions="[
                ['text' => 'Create New', 'permission' => 'users_create', 'icon' => 'fas fa-plus', 'url' => route('admin.users.create'), 'class' => 'btn-success btn-loader'],
                ['text' => 'All Users', 'icon' => 'fas fa-list', 'url' => route('admin.users.index'), 'permission' => 'users_access', 'class' => 'btn-dark btn-loader'],
            ]"
		/>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0 text-dark">User Information</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td><b>Name:</b></td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Email:</b></td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td><b>Mobile:</b></td>
                            <td>{{ $user->mobile }}</td>
                        </tr>
                        <tr>
                            <td><b>Email Verified:</b></td>
                            <td>{{ $user->email_verified_at ? date('d-M-y h:i A', strtotime($user->email_verified_at)) : '' }}</td>
                        </tr>
                        <tr>
                            <td><b>Role:</b></td>
                            <td>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                        </tr>
                        <tr>
                            <td><b>Created:</b></td>
                            <td>{{ date('d-M-y h:i A', strtotime($user->created_at)) }}</td>
                        </tr>

                        <tr>
                            <td colspan="2" class="text-center">
                                @can('user_update')
                                <a href="{{ route('admin.users.edit', [$user]) }}" class="btn btn-success px-3">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                @endcan

                                @can('login_to_user')
                                <a href="{{ route('admin.login-to', [$user]) }}" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt"></i> Login To
                                </a>
                                @endcan
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>


</x-admin.layout>
