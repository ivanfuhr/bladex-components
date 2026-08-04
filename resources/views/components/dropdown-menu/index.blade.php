{{-- display:contents so triggers (e.g. sidebar menu-button w-full) size against the parent, not a shrink-wrapped wrapper --}}
<div {{
    $attributes->class([
        'dropdown-menu',
        'contents',
    ])->merge([
        'data-dropdown-menu' => true,
        'data-align' => $align,
        'data-side' => $side,
    ])
}}>
    {{ $slot }}
</div>
