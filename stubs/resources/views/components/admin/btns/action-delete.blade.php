@can($permission ?? null)
    <form action="{{ $url }}" method="POST" class="d-inline-block">
        @csrf
        @method('DELETE')
        <button @class([
            'btn',
            'btn-loader',
            'delete-alert',
            'btn-'.($color ?? 'danger'),
            'btn-'.($size ?? 'sm'),
            'load-circle' => !($text ?? null),
            ]) >
            {!! $icon ?? '<i class="fas fa-trash"></i>' !!} {{ $text ?? null }}
        </button>
    </form>
@endcan
