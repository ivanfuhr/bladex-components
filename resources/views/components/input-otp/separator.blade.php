@php
    $separatorClasses = collect([
        'input-otp__separator',
        'flex shrink-0 items-center justify-center text-zinc-400 dark:text-zinc-500',
    ])->implode(' ');
@endphp

<div {{
    $attributes->class($separatorClasses)->merge([
        'role' => 'separator',
        'aria-hidden' => 'true',
        'data-input-otp-separator' => true,
    ])
}}>
    @if ($slot->isEmpty())
        <span class="text-sm font-medium">-</span>
    @else
        {{ $slot }}
    @endif
</div>
