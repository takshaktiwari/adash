<div class="breadcrumb-area bg-light border-bottom">
    <div class="container py-3">
        @if($title)
            <h5 class="fw-bold mb-1 lc-1">{{ substr($title, 0, 60) }}</h5>
        @endif

        <ul class="breadcrumb mb-0 fs-6">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            @foreach($links as $link)
                @if(!$loop->last)
                    <li class="breadcrumb-item">
                        <a href="{{ isset($link['url']) ? $link['url'] : 'javascript:void(0)' }}">
                            {{ $link['text'] }}
                        </a>
                    </li>
                @else
                    <li class="breadcrumb-item active">
                        {{ $link['text'] }}
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
