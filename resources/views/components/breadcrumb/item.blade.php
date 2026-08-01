@props([
    'href' => null,
])

<li {{
    $attributes->class([
        'breadcrumb__item',
        'inline-flex items-center gap-1.5',
    ])->merge([
        'data-breadcrumb-item' => true,
    ])
}}>
    @if (filled($href))
        <x-stencil::breadcrumb.link :href="$href">{{ $slot }}</x-stencil::breadcrumb.link>
    @elseif (! $slot->isEmpty())
        {{ $slot }}
    @endif
</li>
