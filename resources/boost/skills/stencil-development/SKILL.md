---
name: stencil-development
description: >
  Configure and apply the Stencil package in Laravel applications.
license: MIT
metadata:
  author: Ivan Führ
---

# Stencil

Use this skill when a Laravel application needs to integrate the Stencil package.

## Primary Goal

- apply the `ivanfuhr/stencil` package's public API in the smallest correct way

## Workflow

### 1. Inspect the Laravel app context

- confirm the app is a Laravel project
- inspect the target code paths where the package should be applied

### 2. Choose adoption mode

**Owned mode (recommended)** — `composer require --dev ivanfuhr/stencil`:

```blade
<x-stencil::input name="email" />
```

**Owned mode** — shadcn-style registry install into `resources/views/ui` (production runs without the package):

```bash
php artisan stencil:init
php artisan stencil:add input
```

```blade
<x-ui::input name="email" />
```

Owned mode runs `init` scaffolding: `app/Support/Stencil` class maps, `resources/css/stencil.css`, `App\Providers\StencilUiServiceProvider`, and marked patches in `resources/css/app.css` / `resources/js/app.js`. Registry `add` installs owned Blade (`x-ui::`) and co-located scripts such as `resources/views/ui/select/select.js`.

**Tailwind:** Scan app paths via `resources/css/stencil.css` (created by `init`; includes `@custom-variant dark` for class-based `dark:*`). Do not import Tailwind sources from `vendor/`. With `APP_DEBUG=true` and the dev package installed, missing integration throws on HTTP requests; set `validate_tailwind_integration` to `false` in config to opt out. Components default to light styles; add `class="dark"` on the layout for dark UIs.

**Select:** `stencil:add select` copies `select.js` and patches the Vite entry. Default `shortcut` wraps `select.item` children; set `:shortcut="false"` for full `select.trigger` / `select.content` composition.

**Combobox:** `stencil:add combobox` copies `combobox.js` and patches the Vite entry. Filterable single-select with `role="combobox"`. Default `shortcut` wraps items with `combobox.input` / `combobox.content` / `combobox.empty`; set `:shortcut="false"` for full composition.

**File Upload:** `stencil:add file-upload` copies `file-upload.js` and patches the Vite entry. Native `<input type="file">` with drag-and-drop dropzone, selected-file list, and client-side remove. Supports `multiple`, `accept`, `disabled`, `invalid`, and Field `$errors`. Default `shortcut` renders dropzone + list; set `:shortcut="false"` for full composition.

**Input OTP:** `stencil:add input-otp` copies `input-otp.js` and patches the Vite entry. Labeled digit/character slots with paste and arrow/backspace navigation. Hidden input submits the combined value. Supports `length` (default 6), `mode` (`numeric` | `alphanumeric`), `separated`, `disabled`, `invalid`, and Field `$errors`. Default `shortcut` renders slots; set `:shortcut="false"` for `group` / `slot` / `separator` composition.

**Slider:** `stencil:add slider` copies `slider.js` and patches the Vite entry. Single or dual-thumb range with `role="slider"`, keyboard arrows / Home / End / PageUp / PageDown, and a hidden form value. Supports `min`, `max`, `step`, `value` (number or `[low, high]`), `:range`, `disabled`, `invalid`, and Field `$errors`. Default `shortcut` renders track / range / thumb; set `:shortcut="false"` for full composition.

**Dialog:** `stencil:add dialog` copies `dialog.js` and adds it to the same `// stencil-start` block in the Vite entry. Compose `dialog.trigger` + `dialog.content` (optional `name` for Flux-style triggers). Use `window.Stencil.dialog('name').show()` from JavaScript when needed.

**Layout / feedback primitives:** Prefer compound `x-ui::*` composition for `accordion`, `collapsible`, `avatar`, `badge`, `breadcrumb`, `card`, `dropdown-menu`, `separator`, `skeleton`, `tabs`, `tooltip`, `toast`, `progress`, `alert`, `table`, and `pagination`. Interactive ones (`accordion`, `collapsible`, `avatar`, `dropdown-menu`, `tabs`, `tooltip`, `toast`) install matching `*.js` via `stencil:add`. Toasts: mount `toast.provider` once and call `window.Stencil.toast({ title, description, variant })` when needed. Pagination accepts a Laravel `LengthAwarePaginator` via `:paginator`.

**Date / time pickers:** `stencil:add date-picker` (depends on `calendar`, `button`, `input`) installs `date-picker.js` plus shared `calendar.js` and `chrono/*` helpers. Values: single date `Y-m-d`, range `Y-m-d/Y-m-d`, time `H:i`, datetime ISO 8601. Set `timezone` (defaults to `config('app.timezone')`). Also available: `time-picker`, `datetime-picker`, and standalone `calendar`.

### 3. Registry CLI

| Command | Purpose |
| --- | --- |
| `stencil:init` | Create `stencil.json`, scaffold owned support/CSS, and empty `stencil.lock` |
| `stencil:add {names}` | Fetch items from the remote registry; resolve `registryDependencies` |
| `stencil:update {name?}` | Sync installed files; use `--overwrite` if edited locally |
| `stencil:remove {names}` | Remove lock entries and files (`--keep-files` optional) |
| `stencil:list` | List registry index (`--installed` for installed names) |

Default registry URL: `config('stencil.default_registry_url')` (overridable in `stencil.json`).

### Typography

- Shared size scale: `sm`, `default`, `lg`, `xl` — configured in `config/stencil.php` (`typography.scale`), overridable in `stencil.json`.
- Pairing defaults: `typography.defaults.text_size` + `heading_level`; default heading is one scale step above default text.
- Google Fonts (CDN): `typography.fonts` + `typography.roles` (`body`, `heading`). Include `<x-stencil::fonts />` in the layout once.
- Components: `<x-stencil::text />`, `<x-stencil::heading />` — font role is automatic; heading size follows `level` (no `size`/`font` props).
- Owned: `stencil:add text heading` → `<x-ui::text />`, `<x-ui::heading />`.

## Rules, References, and Templates

Read before executing:

- package README usage section
- `resources/boost/skills/composing-blade-components/SKILL.md` for component structure

## Examples

- Form field: init → add `input` → `<x-ui::input name="email" />` with Tailwind in the host app
- Quick prototype without copying views: `<x-stencil::input />` from vendor

## Anti-patterns

- do not document package internals here; keep the skill focused on adoption in Laravel apps
- do not use `resources/views/components/ui` for owned mode; owned path is `resources/views/ui`
- do not expect `<x-ui.input>`; the owned namespace uses `x-ui::input` (anonymous path prefix)
