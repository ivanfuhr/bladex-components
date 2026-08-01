@props([
    'orientation' => 'horizontal',
])

@php
    $orientation = $orientation === 'vertical' ? 'vertical' : 'horizontal';
@endphp

<div {{
    $attributes->class([
        'button-group',
        'flex w-fit items-stretch',
        'has-[>[data-button-group]]:gap-2',
        '[&>*]:focus-visible:relative [&>*]:focus-visible:z-10',
        '[&_input]:flex-1',
        $orientation === 'vertical' ? 'flex-col' : 'flex-row',
        $orientation === 'horizontal'
        ? '[&>*:not(:first-child)]:rounded-l-none [&>*:not(:first-child)]:border-l-0 [&>*:not(:last-child)]:rounded-r-none'
        : '[&>*:not(:first-child)]:rounded-t-none [&>*:not(:first-child)]:border-t-0 [&>*:not(:last-child)]:rounded-b-none',
    ])->merge([
        'role' => 'group',
        'data-button-group' => true,
        'data-orientation' => $orientation,
    ])
}}>
    {{ $slot }}
</div>
