@can($permission ?? null)
    <a href="{{ $url }}" @class([
        'btn',
        'btn-loader',
        'btn-' . ($color ?? 'primary'),
        'btn-' . ($size ?? 'sm'),
        'load-circle' => !($text ?? null),
    ])>
        {!! $icon ?? '<i class="fas fa-paper-plane"></i>' !!} {{ $text ?? null }}
    </a>
@endcan
