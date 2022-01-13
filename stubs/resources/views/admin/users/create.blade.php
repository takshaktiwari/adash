<x-admin.layout>
    <x-admin.breadcrumb 
        title='Create User'
        :links="[
            ['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
            ['text' => 'Users', 'url' => route('admin.users.index')],
            ['text' => 'Create']
        ]"
        :actions="[
            ['text' => 'All Users', 'icon' => 'fas fa-list', 'url' => route('admin.users.index'), 'permission' => 'users_access', 'class' => 'btn-dark btn-loader'],
        ]" />
    

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('admin.users.store') }}" method="POST" class="card shadow-sm" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mr-2">
                            <div id="image-preview"></div>
                        </div>
                        <div class="form-group flex-fill">
                            <label for="">Profile Image</label>
                            <input type="file" name="profile_img" class="form-control" id="crop-image">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">User Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required="">
                    </div>
                    <div class="form-group">
                        <label for="">User Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required="">
                    </div>
                    <div class="form-group">
                        <label for="">User Mobile <span class="text-danger">*</span></label>
                        <input type="tel" name="mobile" class="form-control" required="">
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Passowrd <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required="">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Confirm Passowrd <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required="">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Email Verified <span class="text-danger">*</span></label>
                                <select name="email_verified" required="" class="form-control">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>   
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Role <span class="text-danger">*</span></label>
                        <select name="roles[]" multiple="" required="" class="form-control">
                            <option value="">-- Select Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>   
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
    
    <x-slot name="script">
        <script>
            var previewImg = {
                width: '70px', 
                rounded: '50px',
            };
            imageCropper('crop-image', 1/1, previewImg);
        </script>
    </x-slot>
</x-admin.layout>
