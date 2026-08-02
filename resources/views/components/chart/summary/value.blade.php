@props([
    'field' => null,
    'format' => null,
    'fallback' => null,
])

@php
    $encodedFormat = is_array($format) ? \Illuminate\Support\Js::encode($format) : $format;
@endphp

<span {{ $attributes }}>
    <span
        data-chart-slot
        @if (filled($field)) data-field="{{ $field }}" @endif
        @if (filled($encodedFormat)) data-format="{{ $encodedFormat }}" @endif
        @if (filled($fallback)) data-fallback="{{ $fallback }}" @endif
    ></span>
</span>
