@props([
    'html',
])

<article {{ $attributes->class(['docs-prose max-w-none']) }}>{!! $html !!}</article>
