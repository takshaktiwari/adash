<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-dark px-4']) }}>
    {{ $slot }}
</button>
