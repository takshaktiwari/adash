<x-admin.layout>
    <x-admin.breadcrumb title='Edit Users' :links="[
        ['text' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['text' => 'Users', 'url' => route('admin.users.index')],
        ['text' => 'Edit'],
    ]" :actions="[
        [
            'text' => 'Create New',
            'permission' => 'users_create',
            'icon' => 'fas fa-plus',
            'url' => route('admin.users.create'),
            'class' => 'btn-success btn-loader',
        ],
        [
            'text' => 'All Users',
            'icon' => 'fas fa-list',
            'url' => route('admin.users.index'),
            'permission' => 'users_access',
            'class' => 'btn-dark btn-loader',
        ],
    ]" />


    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('admin.users.update', [$user]) }}" method="POST" class="card shadow-sm"
                enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    @method('PUT')
                    <div class="d-flex">
                        <div class="mr-2">
                            <a href="{{ route('admin.users.users.profile_img.remove', [$user]) }}"
                                class="bg-danger user_profile_remove text-white rounded-pill text-center p-0 border border-white border-3 load-circle"><i
                                    class="fas fa-times"></i></a>
                            <div id="image-preview">
                                <img src="{{ $user->profileImg() }}" alt="image" width="70" class="rounded-circle img-thumbnail">
                            </div>
                        </div>
                        <div class="form-group flex-fill">
                            <label for="">Profile Image</label>
                            <input type="file" name="profile_img" class="form-control" id="crop-image">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">User Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required="" value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label for="">User Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required=""
                            value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="">User Mobile <span class="text-danger">*</span></label>
                        <input type="tel" name="mobile" class="form-control" required=""
                            value="{{ $user->mobile }}">
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Passowrd </label>
                                <input type="password" name="password" class="form-control">
                                <span class="small text-danger">Enter password if you want change</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Email Verified <span class="text-danger">*</span></label>
                                <select name="email_verified" required="" class="form-control">
                                    <option value="1" {{ $user->email_verified_at ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ !$user->email_verified_at ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Role <span class="text-danger">*</span></label>
                        <select name="roles[]" multiple="" required="" class="form-control">
                            <option value="">-- Select Role --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-dark">
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
