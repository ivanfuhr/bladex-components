@aware([
    'defaultValue' => null,
    'orientation' => 'horizontal',
    'stepperId' => null,
    'value' => null,
    'disabled' => false,
])

@php
    $isVertical = $orientation === 'vertical';
    $isDisabled = (bool) $disabled;
    $isCurrent = filled($defaultValue) && filled($value) && (string) $value === (string) $defaultValue;

    $triggerId = $attributes->get('id')
        ?? (filled($stepperId) && filled($value) ? $stepperId.'-trigger-'.$value : null);
    $panelId = filled($stepperId) && filled($value) ? $stepperId.'-panel-'.$value : null;
@endphp

<button
    type="button"
    {{
        $attributes->except(['id'])->class([
            'stepper__trigger',
            'inline-flex items-center gap-3 rounded-lg text-left transition-colors',
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10 dark:focus-visible:ring-zinc-300/20',
            $isVertical ? 'w-full' : 'flex-col text-center sm:flex-row sm:text-left',
            $isDisabled ? 'cursor-not-allowed' : 'cursor-pointer',
        ])->merge([
            'id' => $triggerId,
            'data-stepper-trigger' => true,
            'data-value' => filled($value) ? (string) $value : null,
            'aria-controls' => $panelId,
            'aria-current' => $isCurrent ? 'step' : null,
            'disabled' => $isDisabled ? true : null,
            'tabindex' => $isCurrent ? '0' : '-1',
        ])
    }}
>
    {{ $slot }}
</button>
