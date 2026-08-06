---
name: composing-blade-components
description: >-
  Build Std Components using composition: small primitives, slots, and compound
  sub-components instead of monolithic prop APIs. Use when adding or changing package
  Blade views, anonymous or class components, or consumer-facing component examples.
license: MIT
metadata:
  author: Ivan Führ
---

# Composing Std Components

Use this skill when implementing or extending UI in `ivanfuhr/std-components`. Prefer **composition** (nested components and slots) over a single component with many boolean or variant props.

## Primary Goal

Ship flexible Blade components that consumers assemble from small pieces, while keeping each piece’s public surface minimal and testable.

## When to Apply

- Adding a new UI primitive or compound component to the package
- Refactoring a component that has grown a large `@props` list
- Writing usage examples for README, workbench, or tests
- Publishing or overriding views under the `std-components` namespace

## Composition Principles

1. **Small primitives first** — One visual or behavioral concern per component (label, icon, control, layout shell). Compose them at the call site or in a thin wrapper.
2. **Slots over flags** — Use default and named slots (`{{ $header }}`, `<x-slot:actions>`) instead of props like `showHeader`, `footerText`, or `withIcon`.
3. **Compound sub-components** — For structured UI (cards, dialogs, fields), use a root plus dot-named children (for example `alert`, `alert.title`, `alert.description`) rather than one template with many optional regions.
4. **Shared context with `@aware`** — Child components read parent-provided values (variant, size, disabled) via `@aware(['variant'])`. Avoid duplicating the same prop on every child.
5. **Attributes on the outermost element** — Merge `$attributes` on the root DOM node so consumers can set `class`, `id`, `data-*`, and ARIA. Forward only what sub-pieces need as explicit props. Interactive controls (`input`, `button`, and future form primitives) should use `std_apply_interaction()` (from `resources/views/std/helpers.php`) so `disabled`, `readonly`, `data-loading`, and `aria-busy` behave consistently (including `aria-disabled` on link-styled buttons).
6. **Logic in class components, markup in views** — Use a class component when you need validation, computed state, or type-safe constructor props; keep the Blade file focused on structure and composition.
7. **Config for defaults, not structure** — Use `config/std-components.php` for global defaults (prefixes, themes). Do not use config to replace missing sub-components or slots.

## Package Conventions

| Concern | Location |
| -------- | -------- |
| View namespace | `std-components::` (from `loadViewsFrom`) |
| Anonymous components | `resources/views/components/{name}.blade.php` |
| Compound components | `resources/views/components/{name}/index.blade.php` and siblings |
| Class components | `src/View/Components/` (register or auto-discover via namespace) |
| Published overrides | `resources/views/vendor/std-components` (`std-components-views` tag) |
| Translations | `lang/` keys referenced from components, not hard-coded copy |

**Tag naming:** `<x-std::{component}>` and `<x-std::{component}.{piece}>` for nested anonymous components.

## Workflow

### 1. Model the UI as a tree

- List the **root** (single wrapper + attribute merge target).
- List **optional regions** as named slots or sub-components, not props.
- List **shared state** (variant, size) for `@aware` on children.

### 2. Implement the root

- Declare only essential `@props` (for example `variant` with a sensible default).
- Provide `@aware` defaults for children when the root owns the variant.
- Render `{{ $slot }}` and named slots; avoid `@if($showX)` branches driven by boolean props when a slot can be empty.

### 3. Implement children

- Each child does one job; use `@aware` for inherited context.
- Do not require consumers to repeat parent props on every child unless overriding is a documented feature.

### 4. Wire and verify

- Ensure views load via `StdComponentsServiceProvider` (no extra registration for standard anonymous components under `resources/views/components`).
- Add a Pest feature test that renders the composed markup (assert key classes, slots, or accessible roles).
- If behavior is user-facing, add a minimal workbench or README example showing **composition**, not a prop laundry list.

## Examples

### Preferred: compound + slots

```blade
<x-std::field name="email">
    <x-std::field.label>Email</x-std::field.label>

    <x-std::input id="email" name="email" type="email" {{ $attributes }} />

    <x-std::field.description>Optional hint copy.</x-std::field.description>
    <x-std::field.errors name="email" />
</x-std::field>

<x-std::field orientation="inline" name="notifications">
    <x-std::switch name="notifications" />
    <x-std::field.label>Enable notifications</x-std::field.label>
</x-std::field>
```

### Textarea, checkbox, radio, switch

```blade
<x-std::textarea name="bio" rows="4" />

<x-std::checkbox name="terms" value="1" />

<x-std::radio.group name="plan" legend="Plan">
    <x-std::radio value="pro">Pro</x-std::radio>
</x-std::radio.group>

<x-std::switch name="feature" />
```

### Select listbox (shortcut + full composition)

```blade
{{-- Shortcut: only items in the default slot (loads select.js in the app) --}}
<x-std::select name="industry" placeholder="Choose industry…">
    <x-std::select.item value="photo">Photography</x-std::select.item>
</x-std::select>

{{-- Full: :shortcut="false" and explicit trigger / content tree --}}
<x-std::select name="industry" :shortcut="false">
    <x-std::select.trigger>
        <x-std::select.value placeholder="Choose industry…" />
    </x-std::select.trigger>
    <x-std::select.content>
        <x-std::select.item value="photo">Photography</x-std::select.item>
    </x-std::select.content>
</x-std::select>
```

### Combobox autocomplete (shortcut + full composition)

```blade
{{-- Shortcut: only items in the default slot (loads combobox.js in the app) --}}
<x-std::combobox name="framework" placeholder="Search frameworks…">
    <x-std::combobox.item value="laravel">Laravel</x-std::combobox.item>
</x-std::combobox>

{{-- Full: :shortcut="false" and explicit input / content / empty tree --}}
<x-std::combobox name="framework" :shortcut="false">
    <x-std::combobox.input placeholder="Search frameworks…" />
    <x-std::combobox.content>
        <x-std::combobox.empty>No frameworks found.</x-std::combobox.empty>
        <x-std::combobox.item value="laravel">Laravel</x-std::combobox.item>
    </x-std::combobox.content>
</x-std::combobox>
```

### File upload (shortcut + full composition)

```blade
{{-- Shortcut: default dropzone + list (loads file-upload.js in the app) --}}
<x-std::file-upload name="avatar" accept="image/*" text="PNG or JPG up to 5MB" />

{{-- Custom dropzone in the slot --}}
<x-std::file-upload name="attachments" :multiple="true">
    <x-std::file-upload.dropzone heading="Upload documents" text="PDF up to 10MB" />
</x-std::file-upload>

{{-- Full: :shortcut="false" and explicit dropzone / list --}}
<x-std::file-upload name="docs" :multiple="true" :shortcut="false">
    <x-std::file-upload.dropzone heading="Drop files here" text="Any type" />
    <x-std::file-upload.list />
</x-std::file-upload>
```

### Input OTP / PIN (shortcut + full composition)

```blade
{{-- Shortcut: six numeric slots with a middle separator (loads input-otp.js) --}}
<x-std::input-otp name="code" />

{{-- PIN length, alphanumeric mode --}}
<x-std::input-otp name="pin" :length="4" />
<x-std::input-otp name="token" mode="alphanumeric" :separated="false" />

{{-- Full: :shortcut="false" and explicit group / slot / separator tree --}}
<x-std::input-otp name="code" :length="6" :shortcut="false">
    <x-std::input-otp.group>
        <x-std::input-otp.slot :index="0" />
        <x-std::input-otp.slot :index="1" />
        <x-std::input-otp.slot :index="2" />
    </x-std::input-otp.group>
    <x-std::input-otp.separator />
    <x-std::input-otp.group>
        <x-std::input-otp.slot :index="3" />
        <x-std::input-otp.slot :index="4" />
        <x-std::input-otp.slot :index="5" />
    </x-std::input-otp.group>
</x-std::input-otp>
```

### Input prefix / suffix (shortcut + full composition)

```blade
{{-- Shortcut: prefix / suffix props compose input.group parts --}}
<x-std::input name="website" prefix="https://" suffix=".test" placeholder="example.com" />

{{-- Full: explicit group tree --}}
<x-std::input.group>
    <x-std::input.group.prefix>https://</x-std::input.group.prefix>
    <x-std::input name="website" in-group placeholder="example.com" />
    <x-std::input.group.suffix>.test</x-std::input.group.suffix>
</x-std::input.group>
```

### Brand (logo slot + image URLs)

```blade
<x-std::header>
    <x-std::brand href="/" name="Acme Inc." logo="/logo.svg" logo-dark="/logo-dark.svg" alt="Acme" />

    <x-std::brand href="/" name="Launchpad">
        <x-slot:logo>
            <span class="text-xs font-bold">L</span>
        </x-slot:logo>
    </x-std::brand>
</x-std::header>

<x-std::sidebar.brand href="/" name="Acme Inc." logo="/logo.svg" />
```

### Color picker (shortcut + full composition)

```blade
{{-- Shortcut: default trigger + popover tree (loads color-picker.js) --}}
<x-std::color-picker name="brand" value="#3366cc" :dropper="true" />

{{-- Full: :shortcut="false" and explicit trigger / content tree --}}
<x-std::color-picker name="brand" value="#3366cc" :shortcut="false">
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

### Date picker (shortcut + full composition)

```blade
{{-- Shortcut: with* booleans compose panel parts --}}
<x-std::date-picker name="published_at" with-presets with-confirmation />

{{-- Full: :shortcut="false" and explicit trigger / panel tree --}}
<x-std::date-picker name="published_at" :shortcut="false">
    <x-std::date-picker.button />
    <x-std::date-picker.panel>
        <x-std::date-picker.presets />
        <x-std::calendar />
        <x-std::date-picker.footer />
    </x-std::date-picker.panel>
</x-std::date-picker>
```

### Datetime picker (shortcut + full composition)

```blade
{{-- Shortcut: default trigger + panel tree (loads datetime-picker.js) --}}
<x-std::datetime-picker name="scheduled_at" />

{{-- Full: :shortcut="false" and explicit trigger / panel tree --}}
<x-std::datetime-picker name="scheduled_at" :shortcut="false">
    <x-std::date-picker.button data-datetime-picker-trigger />
    <x-std::datetime-picker.panel>
        <div class="relative flex flex-col md:flex-row">
            <div class="shrink-0 p-4">
                <x-std::calendar class="w-fit" data-datetime-picker-calendar />
            </div>
            <div class="hidden w-40 shrink-0 md:block" aria-hidden="true"></div>
            <x-std::datetime-picker.time-list />
        </div>
        <x-std::datetime-picker.footer />
    </x-std::datetime-picker.panel>
</x-std::datetime-picker>
```

### Slider / range (shortcut + full composition)

```blade
{{-- Shortcut: single thumb (loads slider.js in the app) --}}
<x-std::slider name="volume" :value="40" />

{{-- Dual-thumb range (emits name[0] / name[1]) --}}
<x-std::slider name="price" :value="[20, 80]" />
<x-std::slider name="span" :range="true" :min="0" :max="100" />

{{-- Full: :shortcut="false" and explicit track / range / thumb tree --}}
<x-std::slider name="volume" :value="40" :shortcut="false">
    <x-std::slider.track>
        <x-std::slider.range />
    </x-std::slider.track>
    <x-std::slider.thumb :index="0" :value="40" />
</x-std::slider>
```

### Scroll area (shortcut + full composition)

```blade
{{-- Shortcut: viewport + vertical scrollbar (scroll-area.js in the package bundle) --}}
<x-std::scroll-area class="h-72" aria-label="Tags">
    …
</x-std::scroll-area>

{{-- Both axes --}}
<x-std::scroll-area class="h-48 w-96" horizontal type="always">
    …
</x-std::scroll-area>

{{-- Full: :shortcut="false" and explicit viewport / scrollbar / corner tree --}}
<x-std::scroll-area class="h-72" :shortcut="false" type="hover">
    <x-std::scroll-area.viewport>
        …
    </x-std::scroll-area.viewport>
    <x-std::scroll-area.scrollbar orientation="vertical" />
    <x-std::scroll-area.scrollbar orientation="horizontal" />
    <x-std::scroll-area.corner />
</x-std::scroll-area>
```

### Root with `@aware` for children (`field/index.blade.php`)

```blade
@props(['name' => null])

<div {{ $attributes->merge(['class' => 'field']) }} data-field>
    {{ $slot }}
</div>
```

### Child (`field/label.blade.php`)

```blade
@aware(['name'])

<label {{ $attributes->merge(['class' => 'field__label']) }} @if($name) for="{{ $name }}" @endif>
    {{ $slot }}
</label>
```

### Avoid: monolithic props

```blade
{{-- Do not standardize on this pattern in Std Components --}}
<x-std::field
    label="Email"
    name="email"
    :error="$errors->first('email')"
    hint="We never share your email"
    required
    icon="mail"
/>
```

Refactor toward sub-components and slots so consumers control order, optional pieces, and custom markup.

## Anti-Patterns

- Encoding layout or optional regions as many boolean props on one component.
- Passing HTML strings in props instead of slots or dedicated sub-components.
- Duplicating `variant` / `size` on every child when `@aware` from the root is enough.
- Inlining Lucide `<svg>` markup or calling `std_*()` helpers directly in compound components when `icon`, `heading`, or `text` primitives exist.
- Leaking package internals (service provider paths, unpublished partials) in consumer docs.
- Adding PHP helpers or facades for markup that belongs in composable Blade components.
- Breaking published view overrides by renaming slot names or sub-component paths without a changelog note.

## References

- `resources/views/components/` — component templates
- `src/StdComponentsServiceProvider.php` — view namespace and publish tags
- `config/std-components.php` — package defaults
- `resources/boost/skills/std-components-development/SKILL.md` — install, publish, and integration
- Laravel docs: Blade components, slots, `@aware`, and anonymous component directories
