<div {{
    $attributes->class([
        'tabs__list',
        $listClasses,
        $orientation === 'vertical' ? 'flex-col' : null,
    ])->merge([
        'role' => 'tablist',
        'aria-orientation' => $orientation,
        'data-tabs-list' => true,
    ])
}}>
    {{ $slot }}
</div>
