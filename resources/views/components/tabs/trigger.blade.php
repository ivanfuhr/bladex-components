@props([
    'value',
    'disabled' => false,
])

@aware([
    'defaultValue' => null,
    'variant' => 'default',
    'tabsId' => null,
])

@php
    $isSelected = filled($defaultValue) && (string) $value === (string) $defaultValue;
    $isDisabled = (bool) $disabled;

    $triggerId = $attributes->get('id')
        ?? (filled($tabsId) ? $tabsId.'-tab-'.$value : null);
    $panelId = filled($tabsId) ? $tabsId.'-panel-'.$value : null;

    $triggerClasses = match ($variant) {
        'pills' => 'rounded-full px-3 py-1.5 text-sm font-medium data-[state=active]:bg-zinc-900 data-[state=active]:text-white dark:data-[state=active]:bg-zinc-100 dark:data-[state=active]:text-zinc-900',
        'line' => 'border-b-2 border-transparent px-1 py-2 text-sm font-medium data-[state=active]:border-zinc-900 dark:data-[state=active]:border-zinc-100',
        default => 'rounded-md px-3 py-1.5 text-sm font-medium data-[state=active]:bg-white data-[state=active]:text-zinc-950 data-[state=active]:shadow-sm dark:data-[state=active]:bg-zinc-950 dark:data-[state=active]:text-zinc-50',
    };
@endphp

<button
    type="button"
    {{
        $attributes->except(['id'])->class([
            'tabs__trigger',
            'inline-flex items-center justify-center gap-2 whitespace-nowrap transition-colors',
            'text-zinc-600 hover:text-zinc-950 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10',
            'disabled:pointer-events-none disabled:opacity-50',
            'dark:text-zinc-400 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20',
            $triggerClasses,
        ])->merge([
            'id' => $triggerId,
            'role' => 'tab',
            'data-tabs-trigger' => true,
            'data-value' => $value,
            'data-state' => $isSelected ? 'active' : 'inactive',
            'aria-selected' => $isSelected ? 'true' : 'false',
            'aria-controls' => $panelId,
            'tabindex' => $isSelected ? '0' : '-1',
            'disabled' => $isDisabled ? true : null,
        ])
    }}
>
    {{ $slot }}
</button>
