@php
        $isInline = $orientation === 'inline';

    $rootClasses = collect([
        'field',
        'flex min-w-0',
        $isInline ? 'flex-row items-center gap-3' : 'flex-col gap-1.5',
    ])->implode(' ');
@endphp

<div
    {{ $attributes->class($rootClasses)->merge([
        'data-field' => true,
        'data-field-orientation' => $isInline ? 'inline' : 'block',
        'data-invalid' => $fieldInvalid ? 'true' : 'false',
    ]) }}
>
    {{ $slot }}
</div>
