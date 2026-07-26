<div align="center">
    <h1>BladeX Components</h1>
</div>

<p align="center">
    <a href="https://packagist.org/packages/ivanfuhr/bladex-components"><img src="https://img.shields.io/packagist/v/ivanfuhr/bladex-components.svg?style=flat-square" alt="Packagist"></a>
    <a href="https://packagist.org/packages/ivanfuhr/bladex-components"><img src="https://img.shields.io/packagist/php-v/ivanfuhr/bladex-components.svg?style=flat-square" alt="PHP from Packagist"></a>
    <a href="https://packagist.org/packages/ivanfuhr/bladex-components"><img src="https://badge.laravel.cloud/badge/ivanfuhr/bladex-components?style=flat" alt="Laravel versions"></a>
    <a href="https://github.com/ivanfuhr/bladex-components/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/ivanfuhr/bladex-components/tests.yml?branch=main&label=Tests&style=flat-square"></a>
    <a href="https://packagist.org/packages/ivanfuhr/bladex-components"><img src="https://img.shields.io/packagist/dt/ivanfuhr/bladex-components.svg?style=flat-square" alt="Total Downloads"></a>
</p>

Powerful components for Laravel Blade.

## Installation

You can install the package via Composer:

```bash
composer require ivanfuhr/bladex-components
```

You may publish all of the package's resources at once:

```bash
php artisan vendor:publish --tag="bladex-components"
```

Or, you may publish each resource individually:

### Publishing the Configuration File

```bash
php artisan vendor:publish --tag="bladex-components-config"
```

### Publishing the Views

```bash
php artisan vendor:publish --tag="bladex-components-views"
```

### Publishing the Translations

```bash
php artisan vendor:publish --tag="bladex-components-lang"
```

### Publishing the Public Assets

```bash
php artisan vendor:publish --tag="bladex-components-assets"
```

## Usage

BladeX Components supports two adoption modes:

### Vendor mode (quick start)

Install the package and use components from `vendor/` without copying files:

```blade
<x-bladex-components::input name="email" />
```

### Owned mode (shadcn-style)

Copy only the UI primitives you need into your app from the remote registry:

```bash
php artisan bladex-components:init
php artisan bladex-components:add input
```

Owned components are written to `resources/views/ui` and registered as the `ui` Blade namespace:

```blade
<x-ui::input name="email" />
```

Registry commands:

| Command | Description |
| --- | --- |
| `bladex-components:init` | Create `bladex-components.json` and an empty lock file |
| `bladex-components:add {names}` | Install components from the registry |
| `bladex-components:update {name?}` | Refresh installed files from the registry |
| `bladex-components:remove {names}` | Remove installed components |
| `bladex-components:list` | List registry items (`--installed` for installed only) |
| `bladex-components:icon {names?}` | Import Lucide icons into `resources/views/ui/icons` |

### Icons (Lucide)

Icons are imported on demand from [Lucide](https://lucide.dev/icons/) — only the icons you install are added to your app.

```bash
php artisan bladex-components:icon search grip-vertical
```

Imported icons are written to `resources/views/ui/icons` by default (override with `paths.icons` in `bladex-components.json` or `--path=` on the command).

```blade
<x-ui::icons.search />
<x-ui::icons.search variant="mini" class="text-amber-500" />
<x-bladex-components::icon name="search" />
<x-bladex-components::icon.loading class="animate-spin" />

<x-bladex-components::input name="search" placeholder="Search…">
    <x-slot:leading>
        <x-ui::icons.search />
    </x-slot:leading>
</x-bladex-components::input>
```

Supported Lucide variants: `outline` (default, 16px), `mini` (20px), and `micro` (12px). Icons always render at a sensible default size via intrinsic `width`/`height` even when Tailwind does not scan your `resources/views/ui/icons` path. Override with Tailwind `size-*`, `h-*`/`w-*`, and `text-*` classes on the component.

### Tailwind CSS

Several primitives resolve utility classes from **PHP class maps** (for example `ButtonClassMap`) in addition to Blade templates. If your Tailwind `content` / `@source` paths only include `resources/views/**/*.blade.php`, **button backgrounds and variant colors will not be generated** and controls can look unstyled on dark layouts.

Include the package sources in your Tailwind build.

**Tailwind v4** — import the bundled source file from your app stylesheet (adjust the vendor path if needed):

```css
@import "tailwindcss";
@import "../../vendor/ivanfuhr/bladex-components/resources/tailwind/bladex.css";
```

**Tailwind v3** — extend `content`:

```js
content: [
    './resources/views/**/*.blade.php',
    './vendor/ivanfuhr/bladex-components/resources/views/**/*.blade.php',
    './vendor/ivanfuhr/bladex-components/src/Support/**/*.php',
],
```

Dark UIs should use Tailwind’s `dark` variant (`class="dark"` on `<html>` or a layout wrapper) so `variant="primary"` inverts correctly (`bg-zinc-50` text on dark, `bg-zinc-900` on light). Rebuild CSS after changing Tailwind sources (`npm run build` / `npm run dev`).

With `APP_DEBUG=true`, HTTP requests throw a clear exception if this integration is missing (set `bladex-components.validate_tailwind_integration` to `false` in config to disable).

The default registry is the copy shipped inside the installed package (`package://registry.json` in `bladex-components.json` after `init`). If `registry` points to a remote URL that returns 404, the CLI falls back to the package registry automatically.

Override `registry` in `bladex-components.json` to use a published remote index (same shape as `registry/registry.json` in this repository), for example after tagging:

`https://raw.githubusercontent.com/ivanfuhr/bladex-components/main/registry/registry.json`

Maintainers can rebuild the published registry from package sources with:

```bash
composer registry:build
```

### Typography

Body copy and headings use a shared size scale: `sm`, `default`, `lg`, and `xl`. Package components resolve sizes through this scale — configure the Tailwind class mapping once in `config/bladex-components.php` (or override in `bladex-components.json` under `typography.scale`).

Font families are configured declaratively (Google Fonts CDN in v1). Define families under `typography.fonts`, map roles under `typography.roles` (`body` for text, `heading` for headings), and include the layout helper once:

```blade
<head>
    <x-bladex-components::fonts />
</head>
```

Map the CSS variables in your app stylesheet (Tailwind v4 example):

```css
@theme {
    --font-sans: var(--font-sans);
}
```

```blade
<x-bladex-components::heading>Page title</x-bladex-components::heading>

<x-bladex-components::text class="mt-2">
    This is body copy with the default size and body font role.
</x-bladex-components::text>

<x-bladex-components::text size="sm" variant="subtle">Meta text</x-bladex-components::text>
<x-bladex-components::text color="blue">Colored text</x-bladex-components::text>
```

Defaults live under `typography.defaults`: `text_size` (`default` → `text-base`) and `heading_level` (`2` → `h2`). The default heading is always **one step larger** on the scale than default body text (`lg` over `default`), and other levels step up or down from that anchor.

Heading visual size follows `level` relative to that anchor (`1` → `xl`, `2` → `lg`, `3` → `default`, `4`–`6` → `sm` with the package defaults). There is no `size` or `font` prop on these primitives — family comes from the configured role.

Owned mode:

```bash
php artisan bladex-components:add text heading
```

```blade
<x-ui::text>Owned copy</x-ui::text>
```

## Development

Maintainers can preview components in the local Orchestra workbench playbook:

```bash
composer workbench:assets   # or: cd workbench && npm ci && npm run build
composer serve              # visit /playbook
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Thank you for considering contributing to BladeX Components! Please review our [contributing guide](.github/CONTRIBUTING.md) to get started.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Ivan Führ](https://github.com/ivanfuhr)
- [All Contributors](../../contributors)

## License

BladeX Components is open-sourced software licensed under the [MIT license](LICENSE.md).
