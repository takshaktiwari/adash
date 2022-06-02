<x-admin.layout>
    <x-admin.breadcrumb title='Pages Create' :links="[
        ['text' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['text' => 'Pages', 'url' => route('admin.pages.index')],
        ['text' => 'Create'],
    ]" :actions="[
        [
            'text' => 'Create Pages',
            'icon' => 'fas fa-plus',
            'url' => route('admin.pages.create'),
            'permission' => 'pages_create',
            'class' => 'btn-success btn-loader',
        ],
        [
            'text' => 'All Pages',
            'icon' => 'fas fa-list',
            'url' => route('admin.pages.index'),
            'permission' => 'pages_access',
            'class' => 'btn-dark btn-loader',
        ],
    ]" />

    <div class="card">
        <div class="card-header">
            <h5 class="my-auto">{{ $page->title }}</h5>
        </div>
        <div class="card-body">
            <img src="{{ $page->banner() }}" alt="banner" class="w-100">
        </div>
        <div class="card-body border-top">
            {!! $page->content !!}
        </div>
        <div class="card-footer">
            @can('pages_update')
                <a href="{{ route('admin.pages.edit', [$page]) }}" class="btn btn-success btn-loader load-circle">
                    <i class="fas fa-edit"></i> Edit
                </a>
            @endcan

            @can('pages_delete')
                <form action="{{ route('admin.pages.destroy', [$page]) }}" method="POST" class="d-inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger delete-alert btn-loader load-circle"><i class="fas fa-trash"></i>
                        Delete</button>
                </form>
            @endcan
        </div>
    </div>
</x-admin.layout>
