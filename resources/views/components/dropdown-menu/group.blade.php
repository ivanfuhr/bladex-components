<div {{
    $attributes->class([
        'dropdown-menu__group',
    ])->merge([
        'role' => 'group',
        'data-dropdown-menu-group' => true,
        'aria-labelledby' => filled($headingId) ? $headingId : null,
    ])
}}>
    @if (filled($heading))
        <x-std::dropdown-menu.label :id="$headingId">{{ $heading }}</x-std::dropdown-menu.label>
    @endif
    {{ $slot }}
</div>
