@props(['items'])

<div {{ $attributes->merge(['class' => 'd-flex justify-content-between flex-wrap font-14']) }} >
    <div>
        Showing <b>{{ $items->firstItem() }}</b> - <b>{{ $items->lastItem() }}</b> of <b>{{ $items->total() }}</b> Items
    </div>
    <div>Showing <b>{{ $items->currentPage() }}</b> of <b>{{ $items->lastPage() }}</b> Pages</div>
</div>