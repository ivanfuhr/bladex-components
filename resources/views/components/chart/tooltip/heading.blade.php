@props([
    'field' => 'date',
    'format' => null,
])

@php
    $encodedFormat = is_array($format) ? \Illuminate\Support\Js::encode($format) : $format;
@endphp

<div {{
    $attributes->class([
        'flex items-center justify-between border-b border-zinc-200 bg-zinc-50 p-2 text-xs font-medium text-zinc-800 dark:border-zinc-500 dark:bg-zinc-600 dark:text-zinc-100',
    ])
}}>
    <span
        data-chart-slot
        data-field="{{ $field }}"
        @if (filled($encodedFormat)) data-format="{{ $encodedFormat }}" @endif
    ></span>
</div>
