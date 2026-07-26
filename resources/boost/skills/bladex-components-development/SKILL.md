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

**Vendor mode** — `composer require ivanfuhr/bladex-components` only:

```blade
<x-bladex-components::input name="email" />
```

**Owned mode** — shadcn-style registry install into `resources/views/ui`:

```bash
php artisan bladex-components:init
php artisan bladex-components:add input
```

```blade
<x-ui::input name="email" />
```

Owned mode requires `bladex-components.json` at the project root. The package registers `Blade::anonymousComponentPath` for `paths.ui` (default `resources/views/ui`).

### 3. Registry CLI

| Command | Purpose |
| --- | --- |
| `bladex-components:init` | Create `bladex-components.json` + empty `bladex-components.lock` |
| `bladex-components:add {names}` | Fetch items from the remote registry; resolve `registryDependencies` |
| `bladex-components:update {name?}` | Sync installed files; use `--overwrite` if edited locally |
| `bladex-components:remove {names}` | Remove lock entries and files (`--keep-files` optional) |
| `bladex-components:list` | List registry index (`--installed` for installed names) |

Default registry URL: `config('bladex-components.default_registry_url')` (overridable in `bladex-components.json`).

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
