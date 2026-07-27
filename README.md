<div align="center">

<a href="#table-of-contents">
  <img src="docs/images/banner.png" alt="Stencil — the modern component system for Laravel Blade" />
</a>

**Composable Blade primitives for Laravel — registry CLI and owned `x-ui::*` components.**

<p>
    <a href="https://packagist.org/packages/ivanfuhr/stencil"><img src="https://img.shields.io/packagist/v/ivanfuhr/stencil.svg?style=flat-square" alt="Packagist"></a>
    <a href="https://packagist.org/packages/ivanfuhr/stencil"><img src="https://img.shields.io/packagist/php-v/ivanfuhr/stencil.svg?style=flat-square" alt="PHP from Packagist"></a>
    <a href="https://packagist.org/packages/ivanfuhr/stencil"><img src="https://badge.laravel.cloud/badge/ivanfuhr/stencil?style=flat" alt="Laravel versions"></a>
    <a href="https://github.com/ivanfuhr/stencil/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/ivanfuhr/stencil/tests.yml?branch=main&label=Tests&style=flat-square"></a>
    <a href="https://packagist.org/packages/ivanfuhr/stencil"><img src="https://img.shields.io/packagist/dt/ivanfuhr/stencil.svg?style=flat-square" alt="Total Downloads"></a>
</p>

</div>

<br>

<h2 id="table-of-contents">📑 Table of contents</h2>

| 🧩 **Components** | 📖 **Guide** | 🛠 **Project** |
| :--- | :--- | :--- |
| [Button](#button) · [Input](#input) · [Select](#select) · [Typography](#typography) · [Icons](#icons) | [Installation](#installation) · [Usage](#usage) · [Registry CLI](#registry-cli) · [Tailwind](#tailwind-css) · [Playbook](#development) | [Changelog](CHANGELOG.md) · [Contributing](.github/CONTRIBUTING.md) · [Security](.github/SECURITY.md) · [License](LICENSE.md) |

<br>

Copy only what you need with `stencil:add`, use `x-ui::*` in your app, and keep Tailwind v4 + class-based dark mode aligned with the design system.

Follow [Installation](#installation) and [Usage](#usage), then use the component previews further down once items are installed.

---

## Installation

```bash
composer require --dev ivanfuhr/stencil
```

The package is a **development dependency** (registry CLI). Run `stencil:init` and `stencil:add` to copy components into your app under `resources/views/ui` and `app/Support/Stencil`. Commit those files so production can run `composer install --no-dev` without the package.

Optional config publish:

```bash
php artisan vendor:publish --tag=stencil-config
```

<br>

## Usage

Initialize the project, browse the registry, then install only what you need. `stencil:add` resolves **`registryDependencies`** automatically (for example, `input` also installs `input-group`, `field`, and `text`).

```bash
php artisan stencil:init
php artisan stencil:list
php artisan stencil:add input button select
```

`stencil:init` scaffolds `stencil.json`, `stencil.lock`, Tailwind integration (`resources/css/stencil.css` + import in `app.css`), support classes, `<x-ui::fonts />`, and registers `App\Providers\StencilUiServiceProvider` in `bootstrap/providers.php` when that file exists.

Use the owned Blade namespace in your app:

```blade
<x-ui::input name="email" />
```

**Registry UI items:** `button`, `field`, `heading`, `icon`, `input`, `input-group`, `select`, `text`. Lower-level pieces such as `field` and `input-group` are usually installed transitively. **Lucide icons:** run `stencil:add icon` once, then `stencil:icon {name}` per icon (see [Icons](#icons)).

### Registry CLI

<h3 id="registry-cli"></h3>

| Command | Description |
| --- | --- |
| `stencil:init` | Create `stencil.json`, scaffold owned support/CSS, and `stencil.lock` |
| `stencil:add {names}` | Install from the registry (includes dependencies) |
| `stencil:update {name?}` | Refresh installed files |
| `stencil:remove {names}` | Remove installed components |
| `stencil:list` | List registry items (`--installed`, `--all`) |
| `stencil:icon {names}` | Import Lucide icon stubs into `resources/views/ui/icons` |

### Tailwind CSS

<h3 id="tailwind-css"></h3>

Owned UI is scanned from `resources/views` and `app/Support/Stencil` via `resources/css/stencil.css`, with class-based dark mode (`.dark` on `<html>`).

```css
@import "tailwindcss";

/* stencil-start */
@import "./stencil.css";
/* stencil-end */
```

With `APP_DEBUG=true` and the package still installed, missing integration throws a clear exception (disable via `stencil.validate_tailwind_integration` in config). Default registry URL: `package://registry.json` (overridable in `stencil.json`).

<br>

## Development

<h3 id="development"></h3>

```bash
composer playbook              # /playbook — interactive playground
composer workbench:build
composer serve
```

Package registry rebuild (contributors):

```bash
composer registry:build
```

To refresh README screenshots, run the workbench on port `8001`, then:

```bash
composer serve -- --port=8001   # separate terminal, if needed
./scripts/capture-readme-images.sh
```

The script crops to `#readme-media` (installs `playwright-core` under `scripts/` on first run). Targets: `/playbook/media/{buttons|input|select|typography|icons}` and the same paths with `?dark=1`.

<br>

---

Component previews match your GitHub theme via `<picture>` (`prefers-color-scheme`).

<br>

## Button

Variants: `outline`, `primary`, `secondary`, `danger`, `ghost`, `subtle`, `link` — sizes `xs`–`lg`, icon mode (`square`), and `leading` / `trailing` slots.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/buttons-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/buttons-light.png">
  <img src="docs/images/buttons-light.png" alt="Button variants" />
</picture>

```blade
<x-ui::button variant="primary" size="lg">Save changes</x-ui::button>

<x-ui::button variant="outline" square>
    <x-ui::icons.search />
</x-ui::button>
```

```bash
php artisan stencil:add button
```

Icon slots in the example need `stencil:add icon` and `stencil:icon search`.

<br>

## Input

Affixes, `prefix` / `suffix`, and `invalid`, `disabled`, and `readonly` states.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/input-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/input-light.png">
  <img src="docs/images/input-light.png" alt="Input" />
</picture>

```blade
<x-ui::input name="email" type="email" placeholder="you@example.com">
    <x-slot:leading><x-ui::icons.search /></x-slot:leading>
    <x-slot:trailing>
        <x-ui::text inline size="sm" variant="subtle">Clear</x-ui::text>
    </x-slot:trailing>
</x-ui::input>

<x-ui::input name="site" prefix="https://" suffix=".com" placeholder="yoursite" />
```

```bash
php artisan stencil:add input
```

<br>

## Select

Accessible listbox (not a native `<select>`). Subcomponents include `trigger`, `value`, `content`, `group`, `label`, `item`, and `separator`. `stencil:add select` copies `select.js` and patches your Vite entry (for example `resources/js/app.js`) to import it.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/select-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/select-light.png">
  <img src="docs/images/select-light.png" alt="Select" />
</picture>

```blade
<x-ui::select name="industry" placeholder="Choose industry…">
    <x-ui::select.group>
        <x-ui::select.label>Creative</x-ui::select.label>
        <x-ui::select.item value="photo">Photography</x-ui::select.item>
    </x-ui::select.group>
    <x-ui::select.separator />
    <x-ui::select.item value="web">Web development</x-ui::select.item>
</x-ui::select>
```

```bash
php artisan stencil:add select
```

<br>

## Typography

`<x-ui::heading />` with semantic levels `1`–`6` and `<x-ui::text />` with the `sm` / `default` / `lg` / `xl` scale, variants, and colors.

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/typography-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/typography-light.png">
  <img src="docs/images/typography-light.png" alt="Typography" />
</picture>

```blade
<head>
    <x-ui::fonts />
</head>

<x-ui::heading :level="2">Page title</x-ui::heading>
<x-ui::text variant="subtle" size="sm">Meta line</x-ui::text>
<x-ui::text color="blue">Semantic color</x-ui::text>
```

```bash
php artisan stencil:add text heading
```

<br>

## Icons

On-demand [Lucide](https://lucide.dev/icons/) icons — `outline` (16px), `mini` (20px), and `micro` (12px) variants.

Install the icon primitives once, then import only the icons you use:

```bash
php artisan stencil:add icon
php artisan stencil:icon search grip-vertical
```

<picture>
  <source media="(prefers-color-scheme: dark)" srcset="docs/images/icons-dark.png">
  <source media="(prefers-color-scheme: light)" srcset="docs/images/icons-light.png">
  <img src="docs/images/icons-light.png" alt="Icons" />
</picture>

```blade
<x-ui::icons.search />
<x-ui::icons.search variant="mini" class="text-amber-500" />
```

<br>

## Changelog

[CHANGELOG](CHANGELOG.md)

## Contributing

[Contributing guide](.github/CONTRIBUTING.md)

## Security

[Security policy](.github/SECURITY.md)

## Credits

- [Ivan Führ](https://github.com/ivanfuhr)
- [All Contributors](../../contributors)

## License

[MIT](LICENSE.md)
