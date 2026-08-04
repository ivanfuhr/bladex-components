Accessible slider and dual-thumb range control (WAI-ARIA `role="slider"`). Subcomponents include `track`, `range`, and `thumb`. Included in `@stencilScripts`. A hidden input carries the value for form submit (`name`); range mode emits `name[0]` / `name[1]`.

Supports `min` (default `0`), `max` (default `100`), `step` (default `1`), `value` (number or `[low, high]`), and `:range="true"` for two thumbs. Keyboard: arrows, Home/End, PageUp/Down. Set `:shortcut="false"` for full composition. Works inside `field` (inherits `invalid` / Laravel `$errors`).

```blade
<x-ui::slider name="volume" :value="40" />

<x-ui::slider name="level" :min="0" :max="50" :step="5" :value="25" />

<x-ui::slider name="price" :value="[20, 80]" />

<x-ui::slider name="span" :range="true" />

<x-ui::slider name="bad" invalid />
<x-ui::slider name="off" disabled />

{{-- Full composition --}}
<x-ui::slider name="volume" :value="40" :shortcut="false">
    <x-ui::slider.track>
        <x-ui::slider.range />
    </x-ui::slider.track>
    <x-ui::slider.thumb :index="0" :value="40" />
</x-ui::slider>

<x-ui::field name="volume">
    <x-ui::field.label>Volume</x-ui::field.label>
    <x-ui::slider name="volume" :value="40" />
    <x-ui::field.errors name="volume" />
</x-ui::field>
```

<br>
