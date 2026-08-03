<span
    {{
        $attributes->class($valueClasses)->merge([
            'data-placeholder' => $resolvedPlaceholder !== null ? 'true' : null,
        ])
    }}
    data-select-value
>
    @if ($slot->isEmpty())
        {{ $resolvedPlaceholder }}
    @else
        {{ $slot }}
    @endif
</span>
