<x-admin.layout>
    <x-slot name="style">
        <style>
            .permissions .list-group-item { border-radius: 0px; }
            .permissions > ul:nth-child(even) .list-group-item{ background-color: #e4e4e4; }
        </style>
    </x-slot>
	<x-admin.breadcrumb
			title='User Permissions'
			:links="[
				['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
                ['text' => 'Users', 'url' => route('admin.users.index')],
                ['text' =>  'Permissions']
			]"
            :actions="[
                ['text' => 'Create Permissions', 'icon' => 'fas fa-plus', 'url' => route('admin.permissions.create'), 'permission' => 'permissions_create', 'class' => 'btn-success btn-loader'],
                ['text' => 'All Users', 'icon' => 'fas fa-list', 'url' => route('admin.users.index'), 'permission' => 'users_access', 'class' => 'btn-dark btn-loader'],
            ]"
		/>

    <div class="row">
        @foreach($roles as $role)
            <div class="col-md-6">
                <form action="{{ route('admin.permissions.roles.update', [$role]) }}" method="POST" class="card shadow-sm">
                    @csrf
                    <div class="card-header bg-light border-bottom border-secondary pointer text-capitalize font-weight-bold font-18" data-bs-toggle="collapse" data-bs-target="#{{ $role->name }}">
                        {{ $role->name }}
                    </div>
                    <div class="card-body permissions" id="{{ $role->name }}">
                        @foreach($permissions as $key => $permission)
                            <ul class="list-group rounded-0 mb-2">
                                <li class="list-group-item d-flex justify-content-between">
                                    <div class="form-check-inline my-auto flex-fill pr-2">
                                        <label class="form-check-label d-flex">
                                            <div class="my-auto me-1">
                                                <input type="checkbox" name="permissions[]" class="form-check-input" value="{{ $permission->id }}" {{ in_array($permission->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }} >
                                            </div>
                                            <div class="my-auto" data-bs-toggle="popover" data-bs-content="{{ $permission->name }}">
                                                <div>{{ $permission->title }}</div>
                                                <span class="small">{{ $permission->hint }}</span>
                                            </div>
                                        </label>
                                    </div>

                                    @if($permission->children->count() > 0)
                                    <div class="my-auto font-18 pointer" data-bs-toggle="collapse" data-bs-target="#permission{{ $role->id.$key }}">
                                        <i class="fas fa-caret-square-down"></i>
                                    </div>
                                    @endif
                                </li>
                                @if($permission->children->count() > 0)
                                    <ul class="list-group ml-4 collapse" id="permission{{ $role->id.$key }}">
                                        @foreach($permission->children as $permission2)
                                            <li class="list-group-item">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label d-flex">
                                                        <div class="my-auto me-1">
                                                            <input type="checkbox" name="permissions[]" class="form-check-input" value="{{ $permission2->id }}" {{ in_array($permission2->id, $role->permissions->pluck('id')->toArray()) ? 'checked' : '' }} >
                                                        </div>
                                                        <div class="my-auto" data-bs-toggle="popover" data-bs-content="{{ $permission2->name }}">
                                                            <div>{{ $permission2->title }}</div>
                                                            <span class="small">{{ $permission2->hint }}</span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </ul>
                        @endforeach

                        @can('permissions_roles_update')
                            <button type="submit" class="btn btn-dark btn-loader" name="role_id" value="{{ $role->id }}">
                                <i class="fas fa-save"></i> Update
                            </button>
                        @endcan
                    </div>
                </form>
            </div>
        @endforeach
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function($) {
                $('[data-toggle="popover"]').popover();
            });
        </script>
    </x-slot>
</x-admin.layout>
