<x-admin.layout>
    <x-admin.breadcrumb title='Queries' :links="[['text' => 'Dashboard', 'url' => route('admin.dashboard')], ['text' => 'Queries']]" :actions="[
        [
            'text' => 'Queries',
            'icon' => 'fas fa-list',
            'permission' => 'queries_access',
            'url' => route('admin.queries.index'),
            'class' => 'btn-info btn-loader',
        ],
        [
            'text' => 'Blocked',
            'icon' => 'fas fa-ban',
            'url' => route('admin.queries.blocked'),
            'class' => 'btn-danger btn-loader',
        ],
    ]" />

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('admin.queries.blocked.update') }}" method="POST" class="card shadow-sm">
                @csrf
                <div class="card-header">
                    <h5 class="my-auto">Blocked Terms</h5>
                </div>
                <div class="card-body">
                    <input type="text" name="terms" value="{{ implode(',', $terms) }}" data-role="tagsinput" />
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-dark">
                        <i class="fas fa-save"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <style>
            .bootstrap-tagsinput .tag {
                white-space: nowrap;
            }
        </style>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"
            integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @endpush
</x-admin.layout>
