<div
    {{ $attributes->class([
        'button-group',
        'inline-flex items-stretch',
        '[&>[data-button]]:-ml-px [&>[data-button]:first-child]:ml-0',
        '[&>[data-button]:not(:first-child)]:rounded-l-none',
        '[&>[data-button]:not(:last-child)]:rounded-r-none',
        '[&>[data-button]:focus-visible]:relative [&>[data-button]:focus-visible]:z-10',
    ]) }}
    data-button-group
    role="group"
>
    {{ $slot }}
</div>
