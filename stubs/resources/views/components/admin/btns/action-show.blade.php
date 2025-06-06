@can($permission ?? null)
    <a href="{{ $url }}" @class([
        'btn',
        'btn-loader',
        'btn-' . ($color ?? 'info'),
        'btn-' . ($size ?? 'sm'),
        'load-circle' => !($text ?? null),
    ])>
        {!! $icon ?? '<i class="fas fa-info-circle"></i>' !!} {{ $text ?? null }}
    </a>
@endcan
