<div align="center">

<a href="#table-of-contents">
  <img src="docs/images/hero.svg" alt="BladeX Components" />
</a>

# BladeX Components

**Composable Blade primitives for Laravel — vendor quick start or shadcn-style owned UI.**

<p>
    <a href="https://packagist.org/packages/ivanfuhr/bladex-components"><img src="https://img.shields.io/packagist/v/ivanfuhr/bladex-components.svg?style=flat-square" alt="Packagist"></a>
    <a href="https://packagist.org/packages/ivanfuhr/bladex-components"><img src="https://img.shields.io/packagist/php-v/ivanfuhr/bladex-components.svg?style=flat-square" alt="PHP from Packagist"></a>
    <a href="https://packagist.org/packages/ivanfuhr/bladex-components"><img src="https://badge.laravel.cloud/badge/ivanfuhr/bladex-components?style=flat" alt="Laravel versions"></a>
    <a href="https://github.com/ivanfuhr/bladex-components/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/ivanfuhr/bladex-components/tests.yml?branch=main&label=Tests&style=flat-square"></a>
    <a href="https://packagist.org/packages/ivanfuhr/bladex-components"><img src="https://img.shields.io/packagist/dt/ivanfuhr/bladex-components.svg?style=flat-square" alt="Total Downloads"></a>
</p>

</div>

<br>

<h2 id="table-of-contents">📑 Table of contents</h2>

| 🧩 **Components** | 📖 **Guide** | 🛠 **Project** |
| :--- | :--- | :--- |
| [Button](#button) · [Input](#input) · [Select](#select) · [Typography](#typography) · [Icons](#icons) | [Installation](#installation) · [Usage](#usage) · [Registry CLI](#registry-cli) · [Tailwind](#tailwind-css) · [Playbook](#development) | [Changelog](CHANGELOG.md) · [Contributing](.github/CONTRIBUTING.md) · [Security](.github/SECURITY.md) · [License](LICENSE.md) |

<br>

Copy only what you need with `bladex-components:add`, use `x-ui::*` in your app, and keep Tailwind v4 + class-based dark mode aligned with the design system. Screenshots are frameless — background matches the theme (click to enlarge).

<br>

## Button

Variants: `outline`, `primary`, `secondary`, `danger`, `ghost`, `subtle`, `link` — sizes `xs`–`lg`, icon mode (`square`), and `leading` / `trailing` slots.

**Light** · click to enlarge

[![Button variants — light](docs/images/buttons-light.png)](docs/images/buttons-light.png)

**Dark**

[![Button variants — dark](docs/images/buttons-dark.png)](docs/images/buttons-dark.png)

```blade
<x-ui::button variant="primary" size="lg">Save changes</x-ui::button>

<x-ui::button variant="outline" square>
    <x-ui::icons.search />
</x-ui::button>
```

```bash
php artisan bladex-components:add button
```

<br>

## Input

Affixes, `prefix` / `suffix`, and `invalid`, `disabled`, and `readonly` states.

**Light**

[![Input — light](docs/images/input-light.png)](docs/images/input-light.png)

**Dark**

[![Input — dark](docs/images/input-dark.png)](docs/images/input-dark.png)

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
php artisan bladex-components:add input
```

<br>

## Select

Accessible listbox (not a native `<select>`). Subcomponents: `trigger`, `value`, `content`, `group`, `item`. Requires `select.js` in Vite after `add select`.

**Light**

[![Select — light](docs/images/select-light.png)](docs/images/select-light.png)

**Dark**

[![Select — dark](docs/images/select-dark.png)](docs/images/select-dark.png)

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
php artisan bladex-components:add select
```

<br>

## Typography

`<x-ui::heading />` with semantic levels `1`–`6` and `<x-ui::text />` with the `sm` / `default` / `lg` / `xl` scale, variants, and colors.

**Light**

[![Typography — light](docs/images/typography-light.png)](docs/images/typography-light.png)

**Dark**

[![Typography — dark](docs/images/typography-dark.png)](docs/images/typography-dark.png)

```blade
<head>
    <x-bladex-components::fonts />
</head>

<x-ui::heading :level="2">Page title</x-ui::heading>
<x-ui::text variant="subtle" size="sm">Meta line</x-ui::text>
<x-ui::text color="blue">Semantic color</x-ui::text>
```

```bash
php artisan bladex-components:add text heading
```

<br>

## Icons

On-demand [Lucide](https://lucide.dev/icons/) icons — `outline` (16px), `mini` (20px), and `micro` (12px) variants.

**Light**

[![Icons — light](docs/images/icons-light.png)](docs/images/icons-light.png)

**Dark**

[![Icons — dark](docs/images/icons-dark.png)](docs/images/icons-dark.png)

```bash
php artisan bladex-components:icon search grip-vertical
```

```blade
<x-ui::icons.search />
<x-ui::icons.search variant="mini" class="text-amber-500" />
```

<br>

---

## Installation

```bash
composer require --dev ivanfuhr/bladex-components
```

The package is a **development dependency** (registry CLI). After `init` and `add`, your app runs from files under `resources/views/ui` and `app/Support/Bladex` — production can use `composer install --no-dev`.

```bash
php artisan vendor:publish --tag="bladex-components"
```

| Tag | Resource |
| --- | --- |
| `bladex-components-config` | Configuration |
| `bladex-components-views` | Package views |
| `bladex-components-lang` | Translations |
| `bladex-components-assets` | Public assets |

<br>

## Usage

**Vendor (quick start)**

```blade
<x-bladex-components::input name="email" />
```

**Owned (shadcn-style)**

```bash
php artisan bladex-components:init
php artisan bladex-components:add input button select
```

```blade
<x-ui::input name="email" />
```

### Registry CLI

<h3 id="registry-cli"></h3>

| Command | Description |
| --- | --- |
| `bladex-components:init` | Create `bladex-components.json`, support/CSS, and lock file |
| `bladex-components:add {names}` | Install from the registry |
| `bladex-components:update {name?}` | Refresh installed files |
| `bladex-components:remove {names}` | Remove installed components |
| `bladex-components:list` | List registry items (`--installed`) |
| `bladex-components:icon {names?}` | Import Lucide icons |

### Tailwind CSS

<h3 id="tailwind-css"></h3>

`init` creates `resources/css/bladex.css` and patches the import in `app.css`. Scans `resources/views` and `app/Support/Bladex`, and registers class-based dark mode (`.dark` on `<html>`).

```css
@import "tailwindcss";

/* bladex-components-start */
@import "./bladex.css";
/* bladex-components-end */
```

With `APP_DEBUG=true`, missing integration throws a clear exception (disable via `bladex-components.validate_tailwind_integration`). Default registry: `package://registry.json`. Rebuild: `composer registry:build`.

<br>

## Development

<h3 id="development"></h3>

```bash
composer playbook              # /playbook — interactive playground
composer workbench:build
composer serve
```

Refresh README screenshots (server at `http://127.0.0.1:8001`):

```bash
./scripts/capture-readme-images.sh
# Pages: /playbook/media/{buttons|input|select|typography|icons}?dark=1
```

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
