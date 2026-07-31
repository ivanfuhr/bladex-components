---
name: composing-blade-components
description: >-
  Build Stencil using composition: small primitives, slots, and compound
  sub-components instead of monolithic prop APIs. Use when adding or changing package
  Blade views, anonymous or class components, or consumer-facing component examples.
license: MIT
metadata:
  author: Ivan Führ
---

# Composing Stencil

Use this skill when implementing or extending UI in `ivanfuhr/stencil`. Prefer **composition** (nested components and slots) over a single component with many boolean or variant props.

## Primary Goal

Ship flexible Blade components that consumers assemble from small pieces, while keeping each piece’s public surface minimal and testable.

## When to Apply

- Adding a new UI primitive or compound component to the package
- Refactoring a component that has grown a large `@props` list
- Writing usage examples for README, workbench, or tests
- Publishing or overriding views under the `stencil` namespace

## Composition Principles

1. **Small primitives first** — One visual or behavioral concern per component (label, icon, control, layout shell). Compose them at the call site or in a thin wrapper.
2. **Slots over flags** — Use default and named slots (`{{ $header }}`, `<x-slot:actions>`) instead of props like `showHeader`, `footerText`, or `withIcon`.
3. **Compound sub-components** — For structured UI (cards, dialogs, fields), use a root plus dot-named children (for example `alert`, `alert.title`, `alert.description`) rather than one template with many optional regions.
4. **Shared context with `@aware`** — Child components read parent-provided values (variant, size, disabled) via `@aware(['variant'])`. Avoid duplicating the same prop on every child.
5. **Attributes on the outermost element** — Merge `$attributes` on the root DOM node so consumers can set `class`, `id`, `data-*`, and ARIA. Forward only what sub-pieces need as explicit props. Interactive controls (`input`, `button`, and future form primitives) should use `Ivanfuhr\Stencil\Support\Interaction\InteractionStateClassMap` and `InteractionStateAttributes` so `disabled`, `readonly`, `data-loading`, and `aria-busy` behave consistently (including `aria-disabled` on link-styled buttons).
6. **Logic in class components, markup in views** — Use a class component when you need validation, computed state, or type-safe constructor props; keep the Blade file focused on structure and composition.
7. **Config for defaults, not structure** — Use `config/stencil.php` for global defaults (prefixes, themes). Do not use config to replace missing sub-components or slots.

## Package Conventions

| Concern | Location |
| -------- | -------- |
| View namespace | `stencil::` (from `loadViewsFrom`) |
| Anonymous components | `resources/views/components/{name}.blade.php` |
| Compound components | `resources/views/components/{name}/index.blade.php` and siblings |
| Class components | `src/View/Components/` (register or auto-discover via namespace) |
| Published overrides | `resources/views/vendor/stencil` (`stencil-views` tag) |
| Translations | `lang/` keys referenced from components, not hard-coded copy |

**Tag naming:** `<x-stencil::{component}>` and `<x-stencil::{component}.{piece}>` for nested anonymous components.

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

- Ensure views load via `StencilServiceProvider` (no extra registration for standard anonymous components under `resources/views/components`).
- Add a Pest feature test that renders the composed markup (assert key classes, slots, or accessible roles).
- If behavior is user-facing, add a minimal workbench or README example showing **composition**, not a prop laundry list.

## Examples

### Preferred: compound + slots

```blade
<x-stencil::field name="email">
    <x-stencil::field.label>Email</x-stencil::field.label>

    <x-stencil::input id="email" name="email" type="email" {{ $attributes }} />

    <x-stencil::field.description>Optional hint copy.</x-stencil::field.description>
    <x-stencil::field.errors name="email" />
</x-stencil::field>

<x-stencil::field orientation="inline" name="notifications">
    <x-stencil::switch name="notifications" />
    <x-stencil::field.label>Enable notifications</x-stencil::field.label>
</x-stencil::field>
```

### Textarea, checkbox, radio, switch

```blade
<x-stencil::textarea name="bio" rows="4" />

<x-stencil::checkbox name="terms" value="1" />

<x-stencil::radio.group name="plan" legend="Plan">
    <x-stencil::radio value="pro">Pro</x-stencil::radio>
</x-stencil::radio.group>

<x-stencil::switch name="feature" />
```

### Select listbox (shortcut + full composition)

```blade
{{-- Shortcut: only items in the default slot (loads select.js in the app) --}}
<x-stencil::select name="industry" placeholder="Choose industry…">
    <x-stencil::select.item value="photo">Photography</x-stencil::select.item>
</x-stencil::select>

{{-- Full: :shortcut="false" and explicit trigger / content tree --}}
<x-stencil::select name="industry" :shortcut="false">
    <x-stencil::select.trigger>
        <x-stencil::select.value placeholder="Choose industry…" />
    </x-stencil::select.trigger>
    <x-stencil::select.content>
        <x-stencil::select.item value="photo">Photography</x-stencil::select.item>
    </x-stencil::select.content>
</x-stencil::select>
```

### Combobox autocomplete (shortcut + full composition)

```blade
{{-- Shortcut: only items in the default slot (loads combobox.js in the app) --}}
<x-stencil::combobox name="framework" placeholder="Search frameworks…">
    <x-stencil::combobox.item value="laravel">Laravel</x-stencil::combobox.item>
</x-stencil::combobox>

{{-- Full: :shortcut="false" and explicit input / content / empty tree --}}
<x-stencil::combobox name="framework" :shortcut="false">
    <x-stencil::combobox.input placeholder="Search frameworks…" />
    <x-stencil::combobox.content>
        <x-stencil::combobox.empty>No frameworks found.</x-stencil::combobox.empty>
        <x-stencil::combobox.item value="laravel">Laravel</x-stencil::combobox.item>
    </x-stencil::combobox.content>
</x-stencil::combobox>
```

### File upload (shortcut + full composition)

```blade
{{-- Shortcut: default dropzone + list (loads file-upload.js in the app) --}}
<x-stencil::file-upload name="avatar" accept="image/*" text="PNG or JPG up to 5MB" />

{{-- Custom dropzone in the slot --}}
<x-stencil::file-upload name="attachments" :multiple="true">
    <x-stencil::file-upload.dropzone heading="Upload documents" text="PDF up to 10MB" />
</x-stencil::file-upload>

{{-- Full: :shortcut="false" and explicit dropzone / list --}}
<x-stencil::file-upload name="docs" :multiple="true" :shortcut="false">
    <x-stencil::file-upload.dropzone heading="Drop files here" text="Any type" />
    <x-stencil::file-upload.list />
</x-stencil::file-upload>
```

### Input OTP / PIN (shortcut + full composition)

```blade
{{-- Shortcut: six numeric slots with a middle separator (loads input-otp.js) --}}
<x-stencil::input-otp name="code" />

{{-- PIN length, alphanumeric mode --}}
<x-stencil::input-otp name="pin" :length="4" />
<x-stencil::input-otp name="token" mode="alphanumeric" :separated="false" />

{{-- Full: :shortcut="false" and explicit group / slot / separator tree --}}
<x-stencil::input-otp name="code" :length="6" :shortcut="false">
    <x-stencil::input-otp.group>
        <x-stencil::input-otp.slot :index="0" />
        <x-stencil::input-otp.slot :index="1" />
        <x-stencil::input-otp.slot :index="2" />
    </x-stencil::input-otp.group>
    <x-stencil::input-otp.separator />
    <x-stencil::input-otp.group>
        <x-stencil::input-otp.slot :index="3" />
        <x-stencil::input-otp.slot :index="4" />
        <x-stencil::input-otp.slot :index="5" />
    </x-stencil::input-otp.group>
</x-stencil::input-otp>
```

### Slider / range (shortcut + full composition)

```blade
{{-- Shortcut: single thumb (loads slider.js in the app) --}}
<x-stencil::slider name="volume" :value="40" />

{{-- Dual-thumb range (emits name[0] / name[1]) --}}
<x-stencil::slider name="price" :value="[20, 80]" />
<x-stencil::slider name="span" :range="true" :min="0" :max="100" />

{{-- Full: :shortcut="false" and explicit track / range / thumb tree --}}
<x-stencil::slider name="volume" :value="40" :shortcut="false">
    <x-stencil::slider.track>
        <x-stencil::slider.range />
    </x-stencil::slider.track>
    <x-stencil::slider.thumb :index="0" :value="40" />
</x-stencil::slider>
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
{{-- Do not standardize on this pattern in Stencil --}}
<x-stencil::field
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
- Inlining Lucide `<svg>` markup or calling `TypographyClassMap` directly in compound components when `icon`, `heading`, or `text` primitives exist.
- Leaking package internals (service provider paths, unpublished partials) in consumer docs.
- Adding PHP helpers or facades for markup that belongs in composable Blade components.
- Breaking published view overrides by renaming slot names or sub-component paths without a changelog note.

## References

- `resources/views/components/` — component templates
- `src/StencilServiceProvider.php` — view namespace and publish tags
- `config/stencil.php` — package defaults
- `resources/boost/skills/stencil-development/SKILL.md` — install, publish, and integration
- Laravel docs: Blade components, slots, `@aware`, and anonymous component directories
