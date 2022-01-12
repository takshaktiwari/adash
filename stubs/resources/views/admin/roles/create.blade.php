<x-admin.layout>
	<x-admin.breadcrumb 
		title='Roles Create'
		:links="[
			['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
            ['text' => 'Roles', 'url' => route('admin.roles.index')],
            ['text' => 'Create'],
		]"
        :actions="[
            ['text' => 'All Roles', 'icon' => 'fas fa-list', 'url' => route('admin.roles.index'), 'permission' => 'roles_access', 'class' => 'btn-success btn-loader'],
            ['text' => 'Dashboard', 'icon' => 'fas fa-technometer', 'url' => auth()->user()->dashboardRoute(), 'class' => 'btn-dark btn-loader'],
        ]" />
	
    <div class="row">
        <div class="col-md-5">
            <form method="POST" action="{{ route('admin.roles.store') }}" class="card shadow-sm">
                @csrf
                <div class="card-body table-responsive">
                    <label for="">Name <span class="text-danger">*</span></label>  
                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
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
