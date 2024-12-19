<x-admin.layout>
    <x-admin.breadcrumb title='Queries' :links="[['text' => 'Dashboard', 'url' => route('admin.dashboard')], ['text' => 'Queries']]" :actions="[
        [
            'text' => 'Dashboard',
            'icon' => 'fas fa-technometer',
            'url' => auth()->user()->dashboardRoute(),
            'class' => 'btn-dark btn-loader',
        ],
    ]" />

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            {{ $dataTable->table() }}
        </div>
    </div>

    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
</x-admin.layout>
