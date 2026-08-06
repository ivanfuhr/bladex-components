SV canvas, hue slider, Tailwind swatches, and hex field in a popover. Subcomponents include `trigger`, `hex`, `content`, `area`, `hue`, `dropper`, `swatches`, and `swatch`. Included in `@stdScripts`.

Default `shortcut` composes the trigger and popover tree. Use `:dropper="true"` or `:swatches="false"` on the root, or nest parts explicitly with `:shortcut="false"`.

```blade
<x-std::color-picker name="brand_color" value="#3366cc" />
<x-std::color-picker name="accent" :dropper="true" />
<x-std::color-picker name="theme" :swatches="['#ef4444', '#22c55e', '#3b82f6']" />

<x-std::color-picker name="brand_color" value="#3366cc" :shortcut="false">
    <x-std::color-picker.trigger current-value="#3366cc" popover-id="brand-popover">
        <x-std::color-picker.hex current-value="#3366cc" popover-id="brand-popover" />
    </x-std::color-picker.trigger>
    <x-std::color-picker.content popover-id="brand-popover">
        <x-std::color-picker.area />
        <x-std::color-picker.hue />
        <x-std::color-picker.dropper />
        <x-std::color-picker.swatches />
    </x-std::color-picker.content>
</x-std::color-picker>
```

<br>
