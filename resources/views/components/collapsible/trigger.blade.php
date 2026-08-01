@props([
    'asChild' => false,
])

@aware([
    'open' => false,
    'disabled' => false,
])

@php
    $isOpen = (bool) $open;
    $isDisabled = (bool) $disabled;
@endphp

@if ($asChild)
    <div {{
        $attributes->class(['collapsible__trigger', 'contents'])->merge([
            'data-collapsible-trigger' => true,
        ])
    }}>
        {{ $slot }}
    </div>
@else
    <button
        type="button"
        {{
            $attributes->class([
                'collapsible__trigger',
                'inline-flex items-center gap-2 text-sm font-medium text-zinc-950',
                'transition-colors hover:text-zinc-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10',
                'disabled:pointer-events-none disabled:opacity-50',
                'dark:text-zinc-50 dark:hover:text-zinc-300 dark:focus-visible:ring-zinc-300/20',
            ])->merge([
                'data-collapsible-trigger' => true,
                'aria-expanded' => $isOpen ? 'true' : 'false',
                'disabled' => $isDisabled ? true : null,
            ])
        }}
    >
        {{ $slot }}
    </button>
@endif
