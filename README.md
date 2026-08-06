<div align="center">

<a href="#table-of-contents">
  <img src="docs/images/banner.png" alt="Std Components — the modern component system for Laravel Blade" />
</a>

**Composable Blade primitives for Laravel — class components, `x-std::*`, and Tailwind v4.**

<p>
    <a href="https://packagist.org/packages/ivanfuhr/std-components"><img src="https://img.shields.io/packagist/v/ivanfuhr/std-components.svg?style=flat-square" alt="Packagist"></a>
    <a href="https://packagist.org/packages/ivanfuhr/std-components"><img src="https://img.shields.io/packagist/php-v/ivanfuhr/std-components.svg?style=flat-square" alt="PHP from Packagist"></a>
    <a href="https://packagist.org/packages/ivanfuhr/std-components"><img src="https://badge.laravel.cloud/badge/ivanfuhr/std-components?style=flat" alt="Laravel versions"></a>
    <a href="https://github.com/ivanfuhr/std-components/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/ivanfuhr/std-components/tests.yml?branch=main&label=Tests&style=flat-square"></a>
    <a href="https://packagist.org/packages/ivanfuhr/std-components"><img src="https://img.shields.io/packagist/dt/ivanfuhr/std-components.svg?style=flat-square" alt="Total Downloads"></a>
</p>

</div>

<br>

<h2 id="table-of-contents">Table of contents</h2>

| | |
| :--- | :--- |
| **Start here** | [Installation](#installation) · [Usage](#usage) · [Documentation](#documentation) |
| **Project** | [Changelog](CHANGELOG.md) · [Contributing](.github/CONTRIBUTING.md) · [Security](.github/SECURITY.md) · [License](LICENSE.md) |

<br>

Install the package, add the layout directives, import Tailwind entry CSS, and use `x-std::*` components directly from the package.

---

## Installation

```bash
composer require ivanfuhr/std-components
```

Optional config publish:

```bash
php artisan vendor:publish --tag=std-components-config
```

<br>

## Usage

Add Std Components assets to your layout:

```blade
<head>
    @stdStyles
    <x-std::fonts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-std::input name="email" />
    @stdScripts
</body>
```

`@stdScripts` and `@stdStyles` serve the bundled runtime from `/std-components/std-components.js` and `/std-components/std-components.css` (no publish required). Override with `['url' => asset('vendor/std-components/std-components.js')]` when using published assets.

### Assets

| Directive | Description |
| --- | --- |
| `@stdStyles` | Base Std Components CSS (tokens, component layers) |
| `@stdScripts` | Vanilla JS runtime for interactive components |

Publish static assets (optional):

```bash
php artisan vendor:publish --tag=std-components-assets
```

Import extra Lucide icons:

```bash
php artisan std:icon search grip-vertical
```

### Tailwind CSS

Import the package Tailwind entry in your app CSS (class-based dark mode via `.dark` on `<html>`):

```css
@import "tailwindcss";
@import "../../vendor/ivanfuhr/std-components/resources/css/std-components.css";
```

<br>

## Documentation

Component guides, live playgrounds, and copy-ready Blade snippets live in the **Std Components Docs** workbench:

```bash
composer playbook   # opens http://127.0.0.1:8000/playbook/getting-started
```

From there you can browse **Getting started**, search the full catalog (⌘K), and open any component page for usage examples, interactive controls, and generated code.

### Component catalog

| Category | Components |
| :--- | :--- |
| **Forms** | Button, Button Group, Toggle, Toggle Group, Input, Input Currency, Select, Combobox, File Upload, Repeater, Pillbox, Rating, Color Picker, Input OTP, Slider, Label, Field, Textarea, Checkbox, Radio, Switch |
| **Typography** | Text, Heading |
| **Overlays** | Dialog, Command, Dropdown Menu, Popover, Tooltip |
| **Feedback** | Toast, Alert, Progress, Skeleton, Empty, Badge |
| **Navigation** | Breadcrumb, Tabs, Stepper, Pagination, Accordion, Collapsible, Brand, Sidebar |
| **Display** | Avatar, Card, Grid, Stat, Chart, Table, Scroll Area, Separator, Icons |
| **Date & time** | Calendar, Date Picker, Time Picker, Datetime Picker |

Interactive components work with `@stdScripts` in your layout — no per-component JavaScript install step.

<br>

## Development

```bash
composer playbook              # /playbook — interactive documentation
composer workbench:build
composer serve
```

Package registry rebuild (contributors):

```bash
composer registry:build
```

To refresh README screenshots, run the workbench on port `8001`, then:

```bash
composer build
php vendor/bin/testbench serve --port=8001   # separate terminal
./scripts/capture-readme-images.sh
```

Guide content is maintained in `workbench/resources/docs/components/*.md` and extracted from this README via `php scripts/extract-readme-guides.php` when needed.

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
