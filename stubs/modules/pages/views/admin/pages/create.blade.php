<x-admin.layout>
	<x-admin.breadcrumb
			title='Pages Create'
			:links="[
				['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
                ['text' => 'Pages', 'url' => route('admin.pages.index')],
                ['text' => 'Create']
			]"
            :actions="[
                ['text' => 'All Pages', 'icon' => 'fas fa-list', 'url' => route('admin.pages.index'),'permission' => 'pages_access', 'class' => 'btn-dark btn-loader'],
            ]"
		/>

    <form method="POST" action="{{ route('admin.pages.store') }}" class="card shadow-sm" enctype="multipart/form-data">
        @csrf
        <div class="card-body table-responsive">
            <div class="form-group">
                <label for="">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">Banner</label>
                        <input type="file" name="thumbnail" class="form-control" >
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="">-- Select --</option>
                            <option value="1">Active</option>
                            <option value="0">In-Active</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Page Content <span class="text-danger">*</span></label>
                <textarea name="content" rows="4" class="form-control summernote-editor">{{ old('content') }}</textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-dark btn-loader">
                <i class="fas fa-save"></i> Submit
            </button>
        </div>
    </form>
</x-admin.layout>
