<x-admin.layout>
	<x-admin.breadcrumb 
			title='All Testimonials'
			:links="[
				['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
                ['text' => 'Testimonials']
			]"
            :actions="[
                ['text' => 'Create New', 'icon' => 'fas fa-plus', 'url' => route('admin.testimonials.create'), 'permission' => 'testimonials_create', 'class' => 'btn-success btn-loader btn-loader'],
                ['text' => 'Dashboard', 'icon' => 'fas fa-technometer', 'url' => auth()->user()->dashboardRoute(), 'class' => 'btn-dark btn-loader'],
            ]"
		/>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Avatar</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($testimonials as $testimonial)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $testimonial->avatarUrl() }}" alt="image" width="50" class="rounded-circle">
                            </td>
                            <td>
                                {{ $testimonial->title }}
                                <div class="small text-nowrap">{{ $testimonial->subtitle }}</div>
                                <div class="small text-nowrap">
                                    <b>Rating: </b> {{ $testimonial->rating }}
                                </div>
                            </td>
                            <td class="small">{{ $testimonial->content }}</td>
                            <td class="text-nowrap">
                                @can('testimonials_update')
                                <a href="{{ route('admin.testimonials.edit', [$testimonial]) }}" class="btn btn-success btn-sm btn-loader load-circle">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan

                                @can('testimonials_delete')
                                <form action="{{ route('admin.testimonials.destroy', [$testimonial]) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger delete-alert btn-loader load-circle"><i class="fas fa-trash"></i></button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin.layout>
