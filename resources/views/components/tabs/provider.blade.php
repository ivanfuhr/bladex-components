@props([
    'tabsId' => null,
])

<div {{ $attributes->class('contents')->merge(['data-tabs-provider' => true]) }}>{{ $slot }}</div>
