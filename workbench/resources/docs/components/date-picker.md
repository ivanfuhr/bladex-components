Calendar popover with optional range mode, presets sidebar, manual inputs, and confirmation footer. Subcomponents include `button`, `selected`, `input`, `panel`, `presets`, `manual-inputs`, and `footer`. Included in `@stencilScripts`.

`withPresets`, `withInputs`, and `withConfirmation` are shortcut conveniences that compose the matching panel parts.

```blade
<x-ui::date-picker name="published_at" value="2026-07-29" />

<x-ui::date-picker name="range_at" mode="range" with-presets with-inputs with-confirmation />

<x-ui::date-picker name="published_at" value="2026-07-29" :shortcut="false">
    <x-ui::date-picker.button />
    <x-ui::date-picker.panel>
        <x-ui::date-picker.manual-inputs />
        <x-ui::calendar value="2026-07-29" />
        <x-ui::date-picker.footer />
    </x-ui::date-picker.panel>
</x-ui::date-picker>
```

<br>
