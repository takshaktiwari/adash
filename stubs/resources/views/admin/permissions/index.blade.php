<x-admin.layout>
    <x-admin.breadcrumb title='Permissions ' :links="[['text' => 'Dashboard', 'url' => route('admin.dashboard')], ['text' => 'Permissions']]" :actions="[
        [
            'text' => 'New Permission',
            'icon' => 'fas fa-plus',
            'url' => route('admin.permissions.create'),
            'permission' => 'permissions_create',
            'class' => 'btn-success',
        ],
        [
            'text' => 'Roles & Permissions',
            'icon' => 'fas fa-user-shield',
            'url' => route('admin.permissions.roles.index'),
            'class' => 'btn-dark',
        ],
    ]" />

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table mb-0">
                <thead>
                    <th>#</th>
                    <th>Parent</th>
                    <th>Action</th>
                    <th>Hint</th>
                </thead>
                <tbody>
                    @foreach ($permissions as $key => $permission)
                        <tr class="{{ $key % 2 ? 'table-success' : '' }}">
                            <td>{{ $key + 1 }}</td>
                            <td>
                                {{ $permission->title }}
                                <div class="small">{{ $permission->name }}</div>
                            </td>
                            <td>
                                <x-admin.btns.action-edit permission="permissions_update" :url="route('admin.permissions.edit', [$permission])" />

                                <x-admin.btns.action-delete permission="permissions_delete" :url="route('admin.permissions.destroy', [$permission])" />
                            </td>
                            <td>{{ $permission->hint }}</td>
                        </tr>

                        @foreach ($permission->children as $key2 => $permission2)
                            <tr class="table-sm {{ $key % 2 ? 'table-info' : '' }}">
                                <td class="pl-4">{{ $key + 1 . '.' . ($key2 + 1) }}</td>
                                <td class="pl-4">
                                    {{ $permission2->title }}
                                    <span class="small">({{ $permission2->name }})</span>
                                </td>
                                <td class="pl-3">
                                    <x-admin.btns.action-edit permission="permissions_update" :url="route('admin.permissions.edit', [$permission2])" />

                                    <x-admin.btns.action-delete permission="permissions_delete" :url="route('admin.permissions.destroy', [$permission2])" />
                                </td>
                                <td>{{ $permission2->hint }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-admin.layout>
