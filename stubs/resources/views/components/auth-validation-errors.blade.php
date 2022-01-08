@props(['errors'])

@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'alert alert-danger']) }}>
        <div class="font-weight-bold mb-2 border-bottom pb-2">
            {{ __('Whoops! Something went wrong.') }}
        </div>

        <ul class="text-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
