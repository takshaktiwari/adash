<x-admin.layout>
	<x-admin.breadcrumb
			title='Pages Edit'
			:links="[
				['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
                ['text' => 'Pages', 'url' => route('admin.pages.index')],
                ['text' => 'Edit']
			]"
            :actions="[
                ['text' => 'Create Pages', 'icon' => 'fas fa-plus', 'url' => route('admin.pages.create'), 'permission' => 'pages_create', 'class' => 'btn-success btn-loader'],
                ['text' => 'All Pages', 'icon' => 'fas fa-list', 'url' => route('admin.pages.index'), 'permission' => 'pages_access', 'class' => 'btn-dark btn-loader'],
            ]"
		/>

    <form method="POST" action="{{ route('admin.pages.update', [$page]) }}" class="card shadow-sm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body table-responsive">
            <div class="form-group">
                <label for="">Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" required value="{{ $page->title }}">
            </div>
            <div class="row">
                <div class="col-sm-7">
                    <div class="d-flex mb-2">
                        @if($page->banner)
                            <div class="mr-3">
                                <img src="{{ $page->banner() }}" alt="image" width="120" class="rounded">
                            </div>
                        @endif

                        <div class="flex-fill">
                            <label for="">Banner</label>
                            <input type="file" name="thumbnail" class="form-control" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="">-- Select --</option>
                            <option value="1" {{ ($page->status == '1') ? 'selected' : '' }} >Active</option>
                            <option value="0" {{ ($page->status == '0') ? 'selected' : '' }} >In-Active</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Page Content <span class="text-danger">*</span></label>
                <textarea name="content" rows="4" class="form-control summernote-editor">{{ $page->content }}</textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-dark btn-loader">
                <i class="fas fa-save"></i> Submit
            </button>
        </div>
    </form>

</x-admin.layout>
