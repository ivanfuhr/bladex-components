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

The default registry is the copy shipped inside the installed package (`package://registry.json` in `bladex-components.json` after `init`). If `registry` points to a remote URL that returns 404, the CLI falls back to the package registry automatically.

Override `registry` in `bladex-components.json` to use a published remote index (same shape as `registry/registry.json` in this repository), for example after tagging:

`https://raw.githubusercontent.com/ivanfuhr/bladex-components/main/registry/registry.json`

Maintainers can rebuild the published registry from package sources with:

```bash
composer registry:build
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
