@props([
    'value',
    'step' => null,
    'completed' => null,
    'disabled' => false,
])

@aware([
    'defaultValue' => null,
    'orientation' => 'horizontal',
    'stepperId' => null,
])

@php
    $isVertical = $orientation === 'vertical';
    $isDisabled = (bool) $disabled;
    $isCurrent = filled($defaultValue) && (string) $value === (string) $defaultValue;

    $state = match (true) {
        $isCurrent => 'active',
        $completed === true => 'completed',
        default => 'inactive',
    };

    $triggerId = $attributes->get('id')
        ?? (filled($stepperId) ? $stepperId.'-trigger-'.$value : null);
    $panelId = filled($stepperId) ? $stepperId.'-panel-'.$value : null;
@endphp

<li {{
    $attributes->except(['id'])->class([
        'stepper__item',
        'group/step relative flex',
        $isVertical ? 'w-full flex-col' : 'flex-1 flex-col items-center',
        $isDisabled ? 'pointer-events-none opacity-50' : null,
    ])->merge([
        'data-stepper-item' => true,
        'data-value' => (string) $value,
        'data-step' => filled($step) ? (string) $step : null,
        'data-state' => $state,
        'data-disabled' => $isDisabled ? 'true' : null,
        'aria-current' => $isCurrent ? 'step' : null,
    ])
}}>
    {{ $slot }}
</li>
