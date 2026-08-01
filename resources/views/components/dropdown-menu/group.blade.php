@props([
    'heading' => null,
])

<div {{
    $attributes->class([
        'dropdown-menu__group',
    ])->merge([
        'role' => 'group',
        'data-dropdown-menu-group' => true,
    ])
}}>
    @if (filled($heading))
        <x-stencil::dropdown-menu.label>{{ $heading }}</x-stencil::dropdown-menu.label>
    @endif
    {{ $slot }}
</div>
