<x-admin.layout>
	<x-admin.breadcrumb 
			title='Testimonials Edit'
			:links="[
				['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
                ['text' => 'Testimonials', 'url' => route('admin.testimonials.index')],
                ['text' => 'Edit']
			]"
            :actions="[
                ['text' => 'Testimonials', 'icon' => 'fas fa-plus', 'url' => route('admin.testimonials.index'), 'permission' => 'testimonials_access', 'class' => 'btn-success btn-loader btn-loader'],
                ['text' => 'Create Testimonials', 'icon' => 'fas fa-plus', 'url' => route('admin.testimonials.create'), 'permission' => 'testimonials_create', 'class' => 'btn-dark btn-loader btn-loader'],
            ]"
		/>

    <form method="POST" action="{{ route('admin.testimonials.update', [$testimonial]) }}" class="card shadow-sm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body table-responsive">
            <div class="row">
                <div class="col-sm-6">
                    <div class="d-flex">
                        <div class="mr-3">
                            <img src="{{ $testimonial->avatarUrl() }}" alt="image" width="70" class="rounded-circle">
                        </div>
                        <div class="form-group flex-fill">
                            <label for="">Upload Avatar</label>
                            <input type="file" class="form-control" name="avatar">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="Title or Name" value="{{ $testimonial->title }}">
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="form-group">
                        <label for="">Subtitle </label>
                        <input type="text" class="form-control" name="subtitle" placeholder="Location or Degisnation" value="{{ $testimonial->subtitle }}">
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="">Rating </label>
                        <input type="number" class="form-control" name="rating" placeholder="Rating from 0 to 5" value="{{ $testimonial->rating }}" min="1" max="5">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Content <span class="text-danger">*</span> </label>
                <textarea class="form-control" name="content" rows="3" placeholder="Write your content" required>{{ $testimonial->content }}</textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-dark btn-loader">
                <i class="fas fa-save"></i> Submit
            </button>
        </div>
    </form>
</x-admin.layout>
