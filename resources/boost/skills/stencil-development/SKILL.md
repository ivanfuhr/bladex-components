---
name: stencil-development
description: >
  Install and apply ivanfuhr/stencil in Laravel apps: runtime package with
  x-ui::* class components, @stencilScripts/@stencilStyles, Tailwind v4, and
  Lucide icons via stencil:icon.
license: MIT
metadata:
  author: Ivan Führ
---

# Stencil

Use this skill when a Laravel app should adopt or extend `ivanfuhr/stencil`.

## Primary Goal

Ship UI with `x-ui::*` class components from the package. Add `@stencilScripts` and `@stencilStyles` to the layout; import package Tailwind CSS in the app.

## Installation

```bash
composer require ivanfuhr/stencil
```

Layout:

```blade
<head>
    @stencilStyles
    <x-ui::fonts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-ui::button variant="primary">Save</x-ui::button>
    @stencilScripts
</body>
```

Tailwind v4 in `resources/css/app.css`:

```css
@import "tailwindcss";
@import "../../vendor/ivanfuhr/stencil/resources/css/stencil.css";
```

## Commands

| Command | Purpose |
| --- | --- |
| `stencil:icon {names}` | Import extra Lucide icon stubs |
| `vendor:publish --tag=stencil-config` | Publish config |
| `vendor:publish --tag=stencil-assets` | Publish JS/CSS to `public/vendor/stencil` |

## Component model

- Namespace: `x-ui::*` via `Ivanfuhr\Stencil\View\Components\*`
- Each component: PHP class + Blade view under `resources/views/components`
- Interactive behavior: vanilla JS in `resources/assets/js`, bundled to `resources/dist/stencil.js`

## Package development

```bash
npm run build          # bundle JS
composer test          # analyse + lint + pest
composer playbook      # workbench server
```
