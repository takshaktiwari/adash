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
                                <x-admin.btns.action-show permission="pages_show" :url="route('admin.pages.show', [$page])" />
                                <x-admin.btns.action-edit permission="pages_update" :url="route('admin.pages.edit', [$page])" />
                                <x-admin.btns.action-delete permission="pages_delete" :url="route('admin.pages.destroy', [$page])" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin.layout>
