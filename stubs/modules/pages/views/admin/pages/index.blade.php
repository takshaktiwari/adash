<x-admin.layout>
	<x-admin.breadcrumb 
			title='All Pages'
			:links="[
				['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
                ['text' => 'Pages']
			]"
            :actions="[
                ['text' => 'Create New', 'icon' => 'fas fa-plus', 'url' => route('admin.pages.create'), 'permission' => 'pages_create', 'class' => 'btn-dark btn-loader'],
            ]"
		/>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Banner</th>
                        <th>Page</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($page->banner)
                                    <img src="{{ $page->banner() }}" alt="image" width="70" class="rounded">
                                @endif
                            </td>
                            <td>
                                {{ $page->title }}
                                <div class="small">{{ $page->created_at->format('d-M-Y h:i A') }}</div>
                            </td>
                            <td>{{ $page->status ? 'Active' : 'In-Active' }}</td>
                            <td class="text-nowrap">
                                @can('pages_show')
                                <a href="{{ route('admin.pages.show', [$page]) }}" class="btn btn-info btn-sm btn-loader load-circle">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                @endcan

                                @can('pages_update')
                                <a href="{{ route('admin.pages.edit', [$page]) }}" class="btn btn-success btn-sm btn-loader load-circle">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan

                                @can('pages_delete')
                                <form action="{{ route('admin.pages.destroy', [$page]) }}" method="POST" class="d-inline-block">
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
