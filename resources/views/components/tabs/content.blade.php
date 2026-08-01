@props([
    'tabValue' => null,
])

@aware([
    'defaultValue' => null,
    'tabsId' => null,
])

@php
    // Keep the public `value` attribute API, but do not declare it in @props so
    // nested controls are less likely to inherit it. input-otp slots also take
    // an explicit :value prop instead of @aware('value').
    $tabValue = $tabValue ?? $attributes->get('value');
    $attributes = $attributes->except('value');

    if (! filled($tabValue)) {
        throw new \InvalidArgumentException('The tabs content component requires a [value] attribute.');
    }

    $isSelected = filled($defaultValue) && (string) $tabValue === (string) $defaultValue;
    $panelId = $attributes->get('id')
        ?? (filled($tabsId) ? $tabsId.'-panel-'.$tabValue : null);
    $triggerId = filled($tabsId) ? $tabsId.'-tab-'.$tabValue : null;
@endphp

<div {{
    $attributes->except(['id'])->class([
        'tabs__content',
        'mt-2 text-sm text-zinc-700 focus-visible:outline-none dark:text-zinc-300',
        ! $isSelected ? 'hidden' : null,
    ])->merge([
        'id' => $panelId,
        'role' => 'tabpanel',
        'aria-labelledby' => $triggerId,
        'data-tabs-content' => true,
        'data-value' => $tabValue,
        'data-state' => $isSelected ? 'active' : 'inactive',
        'tabindex' => '0',
        'hidden' => $isSelected ? null : true,
    ])
}}>
    {{ $slot }}
</div>
