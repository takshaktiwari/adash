<x-admin.layout>
	<x-admin.breadcrumb 
		title='FAQs Edit'
		:links="[
			['text' => 'Dashboard', 'url' => auth()->user()->dashboardRoute() ],
            ['text' => 'FAQs', 'url' => route('admin.faqs.index')],
            ['text' => 'Edit']
		]"
        :actions="[
            ['text' => 'All FAQs', 'icon' => 'fas fa-list', 'url' => route('admin.faqs.index'), 'permission' => 'faqs_access', 'class' => 'btn-success btn-loader'],
            ['text' => 'Create FAQ', 'icon' => 'fas fa-list', 'url' => route('admin.faqs.create'), 'permission' => 'faqs_create', 'class' => 'btn-dark btn-loader'],
        ]" />
	
    <form method="POST" action="{{ route('admin.faqs.update', [$faq]) }}" class="card shadow-sm">
        @csrf
        @method('PUT')
        <div class="card-body table-responsive">
            <div class="form-group">
                <label for="">Question <span class="text-danger">*</span></label>
                <textarea name="question" rows="2" class="form-control" required>{{ $faq->question }}</textarea>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">Preference </label>
                        <input type="number" name="pref" class="form-control" value="{{ $faq->pref }}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="">-- Select --</option>
                            <option value="1" {{ ($faq->status == '1') ? 'selected' : '' }} >Active</option>
                            <option value="0" {{ ($faq->status == '0') ? 'selected' : '' }} >In-Active</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Answer <span class="text-danger">*</span></label>
                <textarea name="answer" rows="4" class="form-control text-editor">{{ $faq->answer }}</textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-dark btn-loader">
                <i class="fas fa-save"></i> Submit 
            </button>
        </div>
    </form>


    <x-slot name="script">
        <script>
            tinymce.init({
                selector: '.text-editor',
                plugins: 'print preview paste importcss searchreplace autolink autosave directionality code visualblocks visualchars fullscreen image link codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap emoticons',
                imagetools_cors_hosts: ['picsum.photos'],
                menubar: 'file edit view insert format tools table help',
                toolbar1: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent',
                toolbar2: 'numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview print | insertfile image link codesample',
                toolbar_sticky: true,
                autosave_ask_before_unload: true,
                height: 400,
                toolbar_mode: 'sliding',
                file_picker_types: 'image', 
                images_upload_handler: function (blobinfo, success, failure) {     
                    success("data:" + blobinfo.blob().type + ";base64," + blobinfo.base64()); 
                } 
            });
        </script>
    </x-slot>
</x-admin.layout>
