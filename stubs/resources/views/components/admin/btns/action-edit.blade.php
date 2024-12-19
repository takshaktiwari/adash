@can($permission ?? null)
    <a href="{{ $url }}" @class([
        'btn',
        'btn-loader',
        'btn-'.($color ?? 'success'),
        'btn-'.($size ?? 'sm'),
        'load-circle' => !($text ?? null),
        ])>
        <i class="fas fa-edit"></i> {{ $text ?? null }}
    </a>
@endcan
