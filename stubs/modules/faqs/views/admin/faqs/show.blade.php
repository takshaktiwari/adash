<x-admin.layout>
	<x-admin.breadcrumb
		title='All FAQs'
		:links="[
			['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
            ['text' => 'FAQs']
		]"
        :actions="[
            ['text' => 'All Faqs', 'icon' => 'fas fa-list', 'class' => 'btn-secondary btn-loader', 'url' => route('admin.faqs.index'), 'permission' => 'faqs_access' ],
            ['text' => 'Create New', 'icon' => 'fas fa-plus', 'url' => route('admin.faqs.create'), 'permission' => 'faqs_create', 'class' => 'btn-dark btn-loader'],
        ]" />


    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            @if($faq->status)
                <span class="badge badge-success fs-14">Active</span>
            @else
                <span class="badge badge-danger fs-14">In-Active</span>
            @endif

            <table class="table mb-0">
                <tr>
                    <td><b>Question: </b> {{ $faq->question }}</td>
                </tr>
                <tr>
                    <td><b>Answer: </b> {{ $faq->answer }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            @can('faqs_update')
            <a href="{{ route('admin.faqs.edit', [$faq]) }}" class="btn btn-success btn-loader">
                <i class="fas fa-edit"></i> Edit
            </a>
            @endcan

            @can('faqs_delete')
            <form action="{{ route('admin.faqs.destroy', [$faq]) }}" method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger delete-alert btn-loader"><i class="fas fa-trash"></i> Delete</button>
            </form>
            @endcan
        </div>
    </div>
</x-admin.layout>
