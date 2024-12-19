<x-admin.layout>
	<x-admin.breadcrumb
		title='Queries'
		:links="[
			['text' => 'Dashboard', 'url' => route('admin.dashboard') ],
            ['text' => 'Queries'],
		]"
        :actions="[
            ['text' => 'Queries', 'icon' => 'fas fa-list', 'permission' => 'queries_access', 'url' => route('admin.queries.index'), 'class' => 'btn-info btn-loader'],
            ['text' => 'Dashboard', 'icon' => 'fas fa-technometer', 'url' => auth()->user()->dashboardRoute(), 'class' => 'btn-dark btn-loader'],
        ]" />

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <td><b>Name:</b></td>
                                <td>{{ $query->name }}</td>
                            </tr>
                            <tr>
                                <td><b>email:</b></td>
                                <td>{{ $query->email }}</td>
                            </tr>
                            <tr>
                                <td><b>mobile:</b></td>
                                <td>{{ $query->mobile }}</td>
                            </tr>
                            <tr>
                                <td><b>subject:</b></td>
                                <td>{{ $query->subject }}</td>
                            </tr>
                            <tr>
                                <td><b>origin:</b></td>
                                <td>{{ $query->origin }}</td>
                            </tr>
                            <tr>
                                <td><b>title:</b></td>
                                <td>{{ $query->title }}</td>
                            </tr>
                            <tr>
                                <td><b>content:</b></td>
                                <td>{{ $query->content }}</td>
                            </tr>
                            <tr>
                                <td><b>created_at:</b></td>
                                <td>{{ $query->created_at }}</td>
                            </tr>
                            @if($query->others)
                                @foreach ($query->others as $key => $value)
                                    <tr>
                                        <td><b>{{ str()->of($key)->title() }}:</b></td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <x-admin.btns.action-delete permission="queries_delete" :url="route('admin.queries.destroy', [$query])" />
                </div>
            </div>
        </div>
    </div>
</x-admin.layout>
