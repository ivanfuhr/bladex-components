<div {{
    $attributes->class('select__label px-2 pb-0.5 pt-1')->merge([
        'role' => 'presentation',
        'data-select-label' => true,
    ])
}}>
    <x-std::text size="sm" variant="subtle" inline class="text-xs">{{ $slot }}</x-std::text>
</div>
