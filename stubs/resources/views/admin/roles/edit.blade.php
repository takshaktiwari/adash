<x-admin.layout>
	<x-admin.breadcrumb 
		title='Roles Edit'
		:links="[
			['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
            ['text' => 'Roles', 'url' => route('admin.roles.index')],
            ['text' => 'Edit'],
		]"
        :actions="[
            ['text' => 'All Roles', 'icon' => 'fas fa-list', 'url' => route('admin.roles.index'), 'permission' => 'roles_access', 'class' => 'btn-success btn-loader'],
            ['text' => 'New Roles', 'icon' => 'fas fa-plus', 'url' => route('admin.roles.index'), 'permission' => 'roles_create', 'class' => 'btn-dark btn-loader'],
        ]" />
	
    <div class="row">
        <div class="col-md-5">
            <form method="POST" action="{{ route('admin.roles.update', [$role]) }}" class="card shadow-sm">
                @csrf
                @method('PUT')
                <div class="card-body table-responsive">
                    <label for="">Name <span class="text-danger">*</span></label>  
                    <input type="text" name="name" class="form-control" required value="{{ $role->name }}">
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-dark btn-loader">
                        <i class="fas fa-save"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
    
</x-admin.layout>
