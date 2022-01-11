<x-admin.layout>
	<x-admin.breadcrumb 
			title='Testimonials Create'
			:links="[
				['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
                ['text' => 'Testimonials', 'url' => route('admin.testimonials.index')],
                ['text' => 'Create']
			]"
            :actions="[
                ['text' => 'Testimonials', 'icon' => 'fas fa-plus', 'url' => route('admin.testimonials.index'), 'permission' => 'testimonials_access', 'class' => 'btn-success btn-loader btn-loader'],
                ['text' => 'Dashboard', 'icon' => 'fas fa-technometer', 'url' => auth()->user()->dashboardRoute(), 'class' => 'btn-dark btn-loader'],
            ]"
		/>

    <form method="POST" action="{{ route('admin.testimonials.store') }}" class="card shadow-sm" enctype="multipart/form-data">
        @csrf
        <div class="card-body table-responsive">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="form-group">
                        <label for="">Upload Avatar</label>
                        <input type="file" class="form-control" name="avatar">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="form-group">
                        <label for="">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="Title or Name" value="{{ old('title') }}">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="form-group">
                        <label for="">Subtitle </label>
                        <input type="text" class="form-control" name="subtitle" placeholder="Location or Degisnation" value="{{ old('subtitle') }}">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="form-group">
                        <label for="">Rating </label>
                        <input type="number" class="form-control" name="rating" placeholder="Rating from 0 to 5" value="{{ old('rating') }}" min="1" max="5">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Content <span class="text-danger">*</span> </label>
                <textarea class="form-control" name="content" rows="3" placeholder="Write your content" required>{{ old('content') }}</textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-dark btn-loader">
                <i class="fas fa-save"></i> Submit
            </button>
        </div>
    </form>
</x-admin.layout>
