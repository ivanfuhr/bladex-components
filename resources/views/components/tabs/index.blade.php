@props([
    'defaultValue' => null,
    'orientation' => 'horizontal',
    'variant' => 'default',
    'tabsId' => null,
])

@php
    $tabsId = filled($tabsId) ? $tabsId : 'tabs-'.str_replace('.', '', uniqid('', true));
@endphp

<x-stencil::tabs.provider :tabs-id="$tabsId">
    <div {{
        $attributes->class([
            'tabs',
            $orientation === 'vertical' ? 'flex gap-4' : 'flex flex-col gap-2',
        ])->merge([
            'data-tabs' => true,
            'data-tabs-id' => $tabsId,
            'data-orientation' => $orientation,
            'data-variant' => $variant,
            'data-active' => filled($defaultValue) ? $defaultValue : null,
        ])
    }}>
        {{ $slot }}
    </div>
</x-stencil::tabs.provider>
