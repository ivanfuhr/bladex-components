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
