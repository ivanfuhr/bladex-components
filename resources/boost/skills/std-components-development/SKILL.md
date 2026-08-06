---
name: std-components-development
description: >
  Install and apply ivanfuhr/std-components in Laravel apps: runtime package with
  x-std::* class components, @stdScripts/@stdStyles, Tailwind v4, and
  Lucide icons via std:icon.
license: MIT
metadata:
  author: Ivan Führ
---

# Std Components

Use this skill when a Laravel app should adopt or extend `ivanfuhr/std-components`.

## Primary Goal

Ship UI with `x-std::*` class components from the package. Add `@stdScripts` and `@stdStyles` to the layout; import package Tailwind CSS in the app.

## Installation

```bash
composer require ivanfuhr/std-components
```

Layout:

```blade
<head>
    @stdStyles
    <x-std::fonts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-std::button variant="primary">Save</x-std::button>
    @stdScripts
</body>
```

Tailwind v4 in `resources/css/app.css`:

```css
@import "tailwindcss";
@import "../../vendor/ivanfuhr/std-components/resources/css/std-components.css";
```

## Commands

| Command | Purpose |
| --- | --- |
| `std:icon {names}` | Import extra Lucide icon stubs |
| `vendor:publish --tag=std-components-config` | Publish config |
| `vendor:publish --tag=std-components-assets` | Publish JS/CSS to `public/vendor/std-components` |

## Component model

- Namespace: `x-std::*` via `Ivanfuhr\StdComponents\View\Components\*`
- Each component: PHP class + Blade view under `resources/views/components`
- Interactive behavior: vanilla JS in `resources/assets/js`, bundled to `resources/dist/std-components.js`

## Package development

```bash
npm run build          # bundle JS
composer test          # analyse + lint + pest
composer playbook      # workbench server
```
