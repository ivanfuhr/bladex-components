---
name: stencil-development
description: >
  Install and apply ivanfuhr/stencil in Laravel apps: registry CLI
  (stencil:init/add/update/remove/list/icon), owned x-ui::* Blade UI,
  Tailwind v4 + Vite integration, Lucide icons, and composition patterns.
  Use when adding Stencil components, wiring stencil.json, fixing missing
  UI/Tailwind/JS setup, or choosing between x-ui:: and x-stencil::.
license: MIT
metadata:
  author: Ivan Führ
---

# Stencil

Use this skill when a Laravel app should adopt or extend `ivanfuhr/stencil`.

## Primary Goal

Ship the smallest correct owned UI: install via the registry CLI, compose with `x-ui::*`, and leave production able to run without the package (`composer install --no-dev`).

## Mental Model

Stencil is a **dev-only registry CLI** (shadcn-style for Blade). It copies markup, support classes, CSS, and JS into the host app. You customize those owned files; you do not treat vendor views as the production surface.

| Mode | Namespace | When |
| --- | --- | --- |
| **Owned (default)** | `x-ui::*` | App UI. Files live under `resources/views/ui`. Commit them. |
| **Vendor preview (optional)** | `x-stencil::*` | Quick local check while the package is installed. Not the production path. |

Always prefer owned mode for app work.

## Workflow

### 1. Confirm context

- Laravel app with Tailwind v4 + Vite (typical Breeze/Fortify/Jetstream or similar).
- Decide which UI pieces are needed (form field, dialog, sidebar, etc.).
- If `stencil.json` is missing, start at step 2. If present, jump to step 3.

### 2. Install and init (once per app)

```bash
composer require --dev ivanfuhr/stencil
php artisan stencil:init
```

Optional config publish:

```bash
php artisan vendor:publish --tag=stencil-config
```

`stencil:init` creates/scaffolds:

- `stencil.json` + `stencil.lock`
- `resources/css/stencil.css` and a marked import in `resources/css/app.css` (`/* stencil-start */` … `/* stencil-end */`)
- `app/Support/Stencil` support classes
- `App\Providers\StencilUiServiceProvider` (registered in `bootstrap/providers.php` when that file exists)
- empty owned UI roots for later `stencil:add`

Include fonts once in the layout after init:

```blade
<x-ui::fonts />
```

### 3. Install only what you need

```bash
php artisan stencil:list
php artisan stencil:add input button select
```

Rules:

- `stencil:add` resolves `registryDependencies` and declared Lucide `iconDependencies` automatically.
- Prefer root items (`input`, `select`, `dialog`); transitive pieces (`field`, `label`, `input-group`, `icon`) usually arrive with them.
- Interactive components also copy JS and patch the Vite entry inside `// stencil-start` … `// stencil-end`.
- Shared date helpers install under `resources/js/ui/` (for example `date-value.js`, `date-parse.js`, `date-timezone.js`, `anchored-panel.js`); component scripts stay beside owned views (for example `resources/views/ui/select/select.js`).
- After adding JS-backed items, rebuild frontend assets (`npm run dev` / `npm run build`).

Useful flags:

| Command | Flags / notes |
| --- | --- |
| `stencil:init` | `--force` overwrites existing `stencil.json` / scaffold targets |
| `stencil:add {names}` | `--overwrite`, `--dry-run` |
| `stencil:update {name?}` | `--overwrite` when local files diverge |
| `stencil:remove {names}` | `--keep-files` drops lock entries only |
| `stencil:list` | `--installed`, `--all` |
| `stencil:icon {names}` | Lucide stubs → `resources/views/ui/icons` (`--force`, `--path=`) |

Default registry URL: `package://registry.json` via `config('stencil.default_registry_url')` (overridable in `stencil.json`).

### 4. Compose with owned components

Use the anonymous path prefix:

```blade
{{-- correct --}}
<x-ui::input name="email" />
<x-ui::field name="email">
    <x-ui::field.label>Email</x-ui::field.label>
    <x-ui::input id="email" name="email" type="email" />
    <x-ui::field.errors name="email" />
</x-ui::field>

{{-- wrong --}}
<x-ui.input name="email" />
```

Composition defaults:

1. **Shortcut first** — many roots default `shortcut` to `true` and wrap children (select, combobox, command, slider, file-upload, input-otp, color-picker, date/time pickers). Pass only the varying pieces (usually items).
2. **Full tree when needed** — set `:shortcut="false"` and compose explicit children (`select.trigger` / `select.content`, etc.).
3. **Field shell for forms** — wrap controls in `field` for label, description, and Laravel `$errors`; inline controls use `orientation="inline"`.
4. **Own the files** — customize under `resources/views/ui` and `app/Support/Stencil`. Do not import Tailwind sources from `vendor/`.

### 5. Wire layout / theme

- Keep the `stencil.css` import created by init.
- Class-based dark mode: put `class="dark"` on `<html>` (or a root wrapper). Components ship light styles by default.
- With `APP_DEBUG=true` and the package installed, missing Tailwind integration throws on HTTP requests. Opt out with `validate_tailwind_integration => false` in config if intentional.
- Mount `toast.provider` once in the layout when using toasts; call `window.Stencil.toast({ title, description, variant })`.
- Named dialogs: `window.Stencil.dialog('name').show()` / `window.Stencil.dialogs.closeAll()`.

### 6. Verify before finishing

- [ ] Needed items appear in `php artisan stencil:list --installed` / `stencil.lock`
- [ ] Views render as `x-ui::*` (not `x-stencil::*`) in app code
- [ ] `resources/css/app.css` still has the stencil import markers
- [ ] JS-backed components appear in the Vite entry stencil block
- [ ] Owned files are committed so production can drop the dev package

## Owned Paths

| Artifact | Default path |
| --- | --- |
| Blade UI | `resources/views/ui` |
| Icons | `resources/views/ui/icons` |
| Shared JS helpers | `resources/js/ui` |
| Support classes | `app/Support/Stencil` |
| Project config / lock | `stencil.json`, `stencil.lock` |
| Tailwind entry helper | `resources/css/stencil.css` |

## Choose a Registry Item

Install the closest root name, then copy usage from the package README (swap any mental `x-stencil::` examples to `x-ui::`).

| Need | Add |
| --- | --- |
| Text / text / money / OTP / files | `input`, `textarea`, `input-currency`, `input-otp`, `file-upload` |
| Field chrome / labels | usually via `input` deps; or `field`, `label` |
| Buttons / pressed state / grouped actions | `button`, `toggle`, `toggle-group`, `button-group` |
| Lists / autocomplete | `select`, `combobox`, `pillbox` |
| Boolean / choice | `checkbox`, `radio`, `switch`, `rating` |
| Overlay / menus | `dialog`, `command`, `dropdown-menu`, `popover`, `tooltip`, `toast` |
| Disclosure / nav shell | `accordion`, `collapsible`, `sidebar`, `tabs`, `stepper`, `breadcrumb` |
| Layout / feedback | `card`, `stat`, `chart`, `alert`, `empty`, `skeleton`, `separator`, `progress`, `badge`, `avatar` |
| Data display | `table`, `pagination` (`:paginator` for `LengthAwarePaginator`) |
| Dates / times | `date-picker`, `time-picker`, `datetime-picker`, `calendar` |
| Color | `color-picker` |
| Typography | `text`, `heading` (+ layout `<x-ui::fonts />`) |
| Icons | `icon` + `stencil:icon {lucide-name}` for extras |
| Repeatable rows | `repeater` |
| Slider / range | `slider` |

Full catalog: `php artisan stencil:list` (also documented in the package README).

## Typography and Icons

- Scale: `sm`, `default`, `lg`, `xl` — `config/stencil.php` → `typography.*`, overridable in `stencil.json`.
- `<x-ui::text />` uses the scale; `<x-ui::heading />` sizes from `level` (no `size` / `font` props).
- Icons: `stencil:add icon` for the loading spinner primitive; `stencil:icon search` for Lucide stubs → `<x-ui::icon name="search" />` / generated `x-ui::icon.*` stubs.

## Examples

**Email field (owned)**

```bash
php artisan stencil:init
php artisan stencil:add input
```

```blade
<x-ui::field name="email">
    <x-ui::field.label>Email</x-ui::field.label>
    <x-ui::input id="email" name="email" type="email" />
    <x-ui::field.errors name="email" />
</x-ui::field>
```

**Select shortcut**

```bash
php artisan stencil:add select
```

```blade
<x-ui::select name="industry" placeholder="Choose industry…">
    <x-ui::select.item value="photo">Photography</x-ui::select.item>
</x-ui::select>
```

**Vendor preview only (do not ship as app UI)**

```blade
<x-stencil::input name="email" />
```

## Lookup Order

When stuck, read in this order:

1. Host app: `stencil.json`, `stencil.lock`, `resources/views/ui/**`, Vite entry stencil block
2. Package README — Installation, Usage, Registry CLI, and the specific component section
3. Installed owned view for props/slots (`resources/views/ui/{name}`)
4. `resources/boost/skills/composing-blade-components/SKILL.md` — composition principles (examples there use `x-stencil::` for package sources; translate to `x-ui::` in apps)

## Anti-patterns

- Using `x-stencil::*` as the app’s permanent UI while owned mode is available
- Writing components to `resources/views/components/ui` — owned path is `resources/views/ui`
- Using `<x-ui.input>` — owned namespace is `<x-ui::input>`
- Importing Tailwind or component CSS from `vendor/ivanfuhr/stencil`
- Re-implementing a registry component instead of `stencil:add`
- Documenting or depending on package internals (`src/Registry/*`, workbench, playbook) as consumer API
- Forgetting to commit owned UI / support / icon files before deploying with `--no-dev`
- Skipping `stencil:init` and hand-creating partial scaffolding
