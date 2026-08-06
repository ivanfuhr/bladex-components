Accessible slider and dual-thumb range control (WAI-ARIA `role="slider"`). Subcomponents include `track`, `range`, and `thumb`. Included in `@stdScripts`. A hidden input carries the value for form submit (`name`); range mode emits `name[0]` / `name[1]`.

Supports `min` (default `0`), `max` (default `100`), `step` (default `1`), `value` (number or `[low, high]`), and `:range="true"` for two thumbs. Keyboard: arrows, Home/End, PageUp/Down. Set `:shortcut="false"` for full composition. Works inside `field` (inherits `invalid` / Laravel `$errors`).

```blade
<x-std::slider name="volume" :value="40" />

<x-std::slider name="level" :min="0" :max="50" :step="5" :value="25" />

<x-std::slider name="price" :value="[20, 80]" />

<x-std::slider name="span" :range="true" />

<x-std::slider name="bad" invalid />
<x-std::slider name="off" disabled />

{{-- Full composition --}}
<x-std::slider name="volume" :value="40" :shortcut="false">
    <x-std::slider.track>
        <x-std::slider.range />
    </x-std::slider.track>
    <x-std::slider.thumb :index="0" :value="40" />
</x-std::slider>

<x-std::field name="volume">
    <x-std::field.label>Volume</x-std::field.label>
    <x-std::slider name="volume" :value="40" />
    <x-std::field.errors name="volume" />
</x-std::field>
```

<br>
