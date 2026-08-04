SV canvas, hue slider, Tailwind swatches, and hex field in a popover. Subcomponents include `trigger`, `hex`, `content`, `area`, `hue`, `dropper`, `swatches`, and `swatch`. `stencil:add color-picker` copies `color-picker.js`.

Default `shortcut` composes the trigger and popover tree. Use `:dropper="true"` or `:swatches="false"` on the root, or nest parts explicitly with `:shortcut="false"`.

```blade
<x-ui::color-picker name="brand_color" value="#3366cc" />
<x-ui::color-picker name="accent" :dropper="true" />
<x-ui::color-picker name="theme" :swatches="['#ef4444', '#22c55e', '#3b82f6']" />

<x-ui::color-picker name="brand_color" value="#3366cc" :shortcut="false">
    <x-ui::color-picker.trigger current-value="#3366cc" popover-id="brand-popover">
        <x-ui::color-picker.hex current-value="#3366cc" popover-id="brand-popover" />
    </x-ui::color-picker.trigger>
    <x-ui::color-picker.content popover-id="brand-popover">
        <x-ui::color-picker.area />
        <x-ui::color-picker.hue />
        <x-ui::color-picker.dropper />
        <x-ui::color-picker.swatches />
    </x-ui::color-picker.content>
</x-ui::color-picker>
```

<br>
