<li {{
    $attributes->class([
        'breadcrumb__item',
        'shrink-0 items-center gap-1.5',
    ])->merge([
        'data-breadcrumb-item' => true,
    ])
}}>
    @if (filled($href))
        <x-std::breadcrumb.link :href="$href">{{ $slot }}</x-std::breadcrumb.link>
    @elseif (! $slot->isEmpty())
        {{ $slot }}
    @endif
</li>
