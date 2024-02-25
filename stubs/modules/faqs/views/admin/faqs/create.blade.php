<x-admin.layout>
	<x-admin.breadcrumb
		title='FAQs Create'
		:links="[
			['text' => 'Dashboard', 'url' => auth()->user()->dashboardRoute() ],
            ['text' => 'FAQs', 'url' => route('admin.faqs.index')],
            ['text' => 'Create']
		]"
        :actions="[
            ['text' => 'All FAQs', 'icon' => 'fas fa-list', 'url' => route('admin.faqs.index'), 'permission' => 'faqs_access', 'class' => 'btn-dark btn-loader'],
        ]" />

    <form method="POST" action="{{ route('admin.faqs.store') }}" class="card shadow-sm">
        @csrf
        <div class="card-body table-responsive">
            <div class="form-group">
                <label for="">Question <span class="text-danger">*</span></label>
                <textarea name="question" rows="2" class="form-control" required>{{ old('question') }}</textarea>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">Preference </label>
                        <input type="number" name="pref" class="form-control" value="{{ old('pref') }}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="">-- Select --</option>
                            <option value="1" {{ (old('status') == '1') ? 'selected' : '' }} >Active</option>
                            <option value="0" {{ (old('status') == '0') ? 'selected' : '' }} >In-Active</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Answer <span class="text-danger">*</span></label>
                <textarea name="answer" rows="4" class="form-control summernote-editor-editor">{{ old('answer') }}</textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-dark btn-loader">
                <i class="fas fa-save"></i> Submit
            </button>
        </div>
    </form>
</x-admin.layout>
