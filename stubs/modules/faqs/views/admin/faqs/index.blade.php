<x-admin.layout>
	<x-admin.breadcrumb 
		title='All FAQs'
		:links="[
			['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
            ['text' => 'FAQs']
		]"
        :actions="[
            ['text' => 'Filter', 'icon' => 'fas fa-filter', 'class' => 'btn-secondary btn-loader', 'url' => route('admin.faqs.index', ['filter' => 1]),  'permission' => 'faqs_access', ],
            ['text' => 'Create New', 'permission' => 'user_create', 'icon' => 'fas fa-plus', 'url' => route('admin.faqs.create'),  'permission' => 'faqs_create', 'class' => 'btn-dark btn-loader'],
        ]" />

    @if(request()->get('filter'))
        <form class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-fill mr-3">
                        <input type="text" name="search" class="form-control" value="{{ request()->get('search') }}" placeholder="Search here...">
                    </div>
                    <div class="mr-3">
                        <select name="status" class="form-control">
                            <option value="">-- Status --</option>
                            <option value="1" {{ (request()->get('status') == '1') ? 'selected' : '' }} >Active</option>
                            <option value="0" {{ (request()->get('status') == '0') ? 'selected' : '' }} >In-Active</option>
                        </select>
                    </div>
                    <div class="">
                        <button type="submit" class="btn btn-dark btn-loader" name="filter" value="1">
                            <i class="fas fa-search"></i> Submit
                        </button>
                        <a href="{{ route('admin.faqs.index') }}" class="btn btn-danger btn-loader">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    @endif
	
    <div class="card shadow-sm">
        <x-admin.paginator-info :items="$faqs" class="card-header" />
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th class="text-nowrap">Pref / Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faqs as $faq)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $faq->question }}
                                <div class="small">{{ $faq->updated_at->format('d-M-Y h:i a') }}</div>
                            </td>
                            <td>
                                ({{ $faq->pref }}
                                <span class="d-block">
                                    {{ $faq->status ? 'Active' : 'In-Active' }}
                                </span>
                            </td>
                            <td class="text-nowrap">
                                @can('faqs_show')
                                <a href="{{ route('admin.faqs.show', [$faq]) }}" class="btn btn-info btn-sm btn-loader load-circle">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                                @endcan

                                @can('faqs_update')
                                <a href="{{ route('admin.faqs.edit', [$faq]) }}" class="btn btn-success btn-sm btn-loader load-circle">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan

                                @can('faqs_delete')
                                <form action="{{ route('admin.faqs.destroy', [$faq]) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger delete-alert btn-loader load-circle"><i class="fas fa-trash"></i></button>
                                </form>
                                @endcan
                                <div class="small">{{ $faq->created_at->format('d-M-Y h:i a') }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $faqs->links() }}
        </div>
    </div>
</x-admin.layout>
