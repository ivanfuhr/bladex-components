Calendar popover with optional range mode, presets sidebar, manual inputs, and confirmation footer. Subcomponents include `button`, `selected`, `input`, `panel`, `presets`, `manual-inputs`, and `footer`. Included in `@stdScripts`.

`withPresets`, `withInputs`, and `withConfirmation` are shortcut conveniences that compose the matching panel parts.

```blade
<x-std::date-picker name="published_at" value="2026-07-29" />

<x-std::date-picker name="range_at" mode="range" with-presets with-inputs with-confirmation />

<x-std::date-picker name="published_at" value="2026-07-29" :shortcut="false">
    <x-std::date-picker.button />
    <x-std::date-picker.panel>
        <x-std::date-picker.manual-inputs />
        <x-std::calendar value="2026-07-29" />
        <x-std::date-picker.footer />
    </x-std::date-picker.panel>
</x-std::date-picker>
```

<br>
