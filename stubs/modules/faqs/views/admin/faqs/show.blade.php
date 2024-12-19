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
            <x-admin.btns.action-edit permission="faqs_update" :url="route('admin.faqs.edit', [$faq])" size="md" text="Edit" />
            <x-admin.btns.action-delete permission="faqs_delete" :url="route('admin.faqs.destroy', [$faq])" size="md" text="Delete" />
        </div>
    </div>
</x-admin.layout>
