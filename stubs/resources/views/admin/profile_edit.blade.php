<x-admin.layout>
	<x-admin.breadcrumb
			title='Update Account'
			:links="[
				['text' => 'Dashboard', 'url' => route('admin.dashboard')],
				['text' => 'Update Account']
			]"
			:actions="[
				['text' => 'Dashboard', 'url' => route('admin.dashboard') ]
			]"
		/>

	<div class="row">
		<div class="col-md-6">
			<form action="{{ route('admin.profile.update') }}" method="POST" class="card shadow-sm" enctype="multipart/form-data">
				@csrf
				<div class="card-body">
                    <div class="d-flex">
                        <div class="mr-2">
                            <a href="{{ route('admin.users.users.profile_img.remove', [auth()->user()]) }}"
                                class="bg-danger user_profile_remove text-white rounded-pill text-center p-0 border border-white border-3 load-circle"><i
                                    class="fas fa-times"></i></a>
                            <div id="image-preview">
                                <img src="{{ auth()->user()->profileImg() }}" alt="image" width="70" class="rounded-circle img-thumbnail">
                            </div>
                        </div>
                        <div class="form-group flex-fill">
                            <label for="">Profile Image</label>
                            <input type="file" name="profile_img" class="form-control" id="crop-image">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">User Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required="" value="{{ auth()->user()->name }}">
                    </div>
                    <div class="form-group">
                        <label for="">User Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required=""
                            value="{{ auth()->user()->email }}">
                    </div>
                    <div class="form-group">
                        <label for="">User Mobile <span class="text-danger">*</span></label>
                        <input type="tel" name="mobile" class="form-control" required=""
                            value="{{ auth()->user()->mobile }}">
                    </div>
                    <div class="form-group mb-0">
                        <label for="">Passowrd </label>
                        <input type="password" name="password" class="form-control">
                        <span class="small text-danger">Enter password if you want change</span>
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

    @push('styles')
        <style>
            .user_profile_remove {
                position: absolute;
                width: 25px;
                height: 25px;
                font-size: 15px;
            }

        </style>
    @endpush
    <x-slot name="script">
        <script>
            var previewImg = {
                width: '70px',
                rounded: '50px',
            };
            imageCropper('crop-image', 1 / 1, previewImg);
        </script>
    </x-slot>
</x-admin.layout>
