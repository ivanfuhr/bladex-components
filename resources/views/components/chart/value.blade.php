@props([
    'field' => null,
    'format' => null,
])

@php
    $encodedFormat = is_array($format) ? \Illuminate\Support\Js::encode($format) : $format;
@endphp

<span {{ $attributes }}>
    <span
        data-chart-slot
        @if (filled($field)) data-field="{{ $field }}" @endif
        @if (filled($encodedFormat)) data-format="{{ $encodedFormat }}" @endif
    ></span>
</span>
