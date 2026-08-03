<div {{
    $attributes->class([
        'dropdown-menu__group',
    ])->merge([
        'role' => 'group',
        'data-dropdown-menu-group' => true,
    ])
}}>
    @if (filled($heading))
        <x-ui::dropdown-menu.label>{{ $heading }}</x-ui::dropdown-menu.label>
    @endif
    {{ $slot }}
</div>
