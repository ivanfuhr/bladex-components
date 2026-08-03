<li {{
    $attributes->class([
        'breadcrumb__item',
        'inline-flex items-center gap-1.5',
    ])->merge([
        'data-breadcrumb-item' => true,
    ])
}}>
    @if (filled($href))
        <x-ui::breadcrumb.link :href="$href">{{ $slot }}</x-ui::breadcrumb.link>
    @elseif (! $slot->isEmpty())
        {{ $slot }}
    @endif
</li>
