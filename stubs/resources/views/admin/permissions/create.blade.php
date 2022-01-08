<x-admin.layout>
	<x-admin.breadcrumb 
			title='Permissions Create'
			:links="[
				['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
                ['text' => 'Permissions', 'url' => route('admin.permissions.index')],
                ['text' => 'Create']
			]"
            :actions="[
                ['text' => 'All Permissions', 'icon' => 'fas fa-list', 'url' => route('admin.permissions.index'), 'permission' => 'permissions_access', 'class' => 'btn-dark btn-loader'],
                ['text' => 'Dashboard', 'icon' => 'fas fa-technometer', 'url' => auth()->user()->dashboardRoute(), 'class' => 'btn-dark btn-loader'],
            ]"
		/>
	

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('admin.permissions.store') }}" method="POST" class="card shadow-sm">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Parent </label>
                        <select name="permission_id" class="form-control select2" id="permission_id">
                            <option value="">-- Select --</option>
                            @foreach($permissions as $permission)
                                <option value="{{ $permission->id }}">
                                    {{ $permission->title .' -> '.$permission->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Permission Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required="">
                    </div>
                    <div class="form-group">
                        <label for="">Permission Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required="">
                    </div>
                    <div class="form-group">
                        <label for="">Hint </label>
                        <textarea name="hint" class="form-control" ></textarea>
                    </div>
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
