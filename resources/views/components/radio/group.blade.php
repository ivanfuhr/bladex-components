@props([
    'name' => null,
    'value' => null,
    'legend' => null,
    'invalid' => false,
])

@aware([
    'fieldInvalid' => false,
])

@php
    $isInvalid = $invalid || $fieldInvalid;

    $groupAttributes = $attributes
        ->class([
            'radio-group',
            'flex flex-col gap-3',
        ])
        ->merge([
            'data-radio-group' => true,
        ]);

    if ($isInvalid) {
        $groupAttributes = $groupAttributes->merge(['aria-invalid' => 'true']);
    }
@endphp

<fieldset {{ $groupAttributes }}>
    @if (filled($legend))
        <legend class="mb-1">
            <x-stencil::text
                size="sm"
                class="font-medium text-zinc-950 dark:text-zinc-50"
            >{{ $legend }}</x-stencil::text>
        </legend>
    @endif

    {{ $slot }}
</fieldset>
