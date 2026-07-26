---
name: bladex-components-development
description: >
  Configure and apply the BladeX Components package in Laravel applications.
license: MIT
metadata:
  author: Ivan Führ
---

# BladeX Components

Use this skill when a Laravel application needs to integrate the BladeX Components package.

## Primary Goal

- apply the `ivanfuhr/bladex-components` package's public API in the smallest correct way

## Workflow

### 1. Inspect the Laravel app context

- confirm the app is a Laravel project
- inspect the target code paths where the package should be applied

### 2. Choose adoption mode

**Owned mode (recommended)** — `composer require --dev ivanfuhr/bladex-components`:

```blade
<x-bladex-components::input name="email" />
```

**Owned mode** — shadcn-style registry install into `resources/views/ui` (production runs without the package):

```bash
php artisan bladex-components:init
php artisan bladex-components:add input
```

```blade
<x-ui::input name="email" />
```

Owned mode runs `init` scaffolding: `app/Support/Bladex` class maps, `resources/css/bladex.css`, `App\Providers\BladexUiServiceProvider`, and marked patches in `resources/css/app.css` / `resources/js/app.js`. Registry `add` installs owned Blade (`x-ui::`) and co-located scripts such as `resources/views/ui/select/select.js`.

**Tailwind:** Scan app paths via `resources/css/bladex.css` (created by `init`). Do not import Tailwind sources from `vendor/`. With `APP_DEBUG=true` and the dev package installed, missing integration throws on HTTP requests; set `validate_tailwind_integration` to `false` in config to opt out. Use `class="dark"` on the layout for dark UIs.

**Select:** `bladex-components:add select` copies `select.js` and patches the Vite entry. Default `shortcut` wraps `select.item` children; set `:shortcut="false"` for full `select.trigger` / `select.content` composition.

### 3. Registry CLI

| Command | Purpose |
| --- | --- |
| `bladex-components:init` | Create `bladex-components.json`, scaffold owned support/CSS, and empty `bladex-components.lock` |
| `bladex-components:add {names}` | Fetch items from the remote registry; resolve `registryDependencies` |
| `bladex-components:update {name?}` | Sync installed files; use `--overwrite` if edited locally |
| `bladex-components:remove {names}` | Remove lock entries and files (`--keep-files` optional) |
| `bladex-components:list` | List registry index (`--installed` for installed names) |

Default registry URL: `config('bladex-components.default_registry_url')` (overridable in `bladex-components.json`).

### Typography

- Shared size scale: `sm`, `default`, `lg`, `xl` — configured in `config/bladex-components.php` (`typography.scale`), overridable in `bladex-components.json`.
- Pairing defaults: `typography.defaults.text_size` + `heading_level`; default heading is one scale step above default text.
- Google Fonts (CDN): `typography.fonts` + `typography.roles` (`body`, `heading`). Include `<x-bladex-components::fonts />` in the layout once.
- Components: `<x-bladex-components::text />`, `<x-bladex-components::heading />` — font role is automatic; heading size follows `level` (no `size`/`font` props).
- Owned: `bladex-components:add text heading` → `<x-ui::text />`, `<x-ui::heading />`.

## Rules, References, and Templates

Read before executing:

- package README usage section
- `resources/boost/skills/composing-blade-components/SKILL.md` for component structure

## Examples

- Form field: init → add `input` → `<x-ui::input name="email" />` with Tailwind in the host app
- Quick prototype without copying views: `<x-bladex-components::input />` from vendor

## Anti-patterns

- do not document package internals here; keep the skill focused on adoption in Laravel apps
- do not use `resources/views/components/ui` for owned mode; owned path is `resources/views/ui`
- do not expect `<x-ui.input>`; the owned namespace uses `x-ui::input` (anonymous path prefix)
