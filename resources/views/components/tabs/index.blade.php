<x-std::tabs.provider :tabs-id="$tabsId" :default-value="$defaultValue" :variant="$variant" :orientation="$orientation">
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
</x-std::tabs.provider>
