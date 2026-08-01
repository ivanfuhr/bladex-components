<?php

declare(strict_types=1);

/**
 * Build registry JSON from package Blade sources under resources/views/components.
 *
 * Usage: php scripts/build-registry.php
 */
$root = dirname(__DIR__);

require $root.'/vendor/autoload.php';

use Ivanfuhr\Stencil\Registry\OwnedArtifactCompiler;

$componentsPath = $root.'/resources/views/components';
$registryPath = $root.'/registry';
$itemsPath = $registryPath.'/items';
$compiler = new OwnedArtifactCompiler;

if (! is_dir($componentsPath)) {
    fwrite(STDERR, "Components path not found: {$componentsPath}\n");
    exit(1);
}

/** @var array<string, array{title: string, description: string, type: string, registryDependencies: list<string>, iconDependencies?: list<string>, source?: string, targetPrefix?: string, filesOnly?: list<string>, assets?: array<string, string>}> $catalog */
$chronoAppFiles = [
    'src/Support/Chrono/ChronoFormatter.php' => 'app/Support/Stencil/Chrono/ChronoFormatter.php',
    'src/Support/Chrono/DateRange.php' => 'app/Support/Stencil/Chrono/DateRange.php',
    'src/Support/Chrono/DateRangePreset.php' => 'app/Support/Stencil/Chrono/DateRangePreset.php',
];
$catalog = [
    'label' => [
        'title' => 'Label',
        'description' => 'Accessible label primitive with optional badge and required indicator.',
        'type' => 'registry:ui',
        'registryDependencies' => ['text'],
        'source' => 'label',
        'targetPrefix' => 'label',
        'filesOnly' => ['index.blade.php'],
    ],
    'field' => [
        'title' => 'Field',
        'description' => 'Composable form field shell with label, description, messages, and validation errors.',
        'type' => 'registry:ui',
        'registryDependencies' => ['label', 'text'],
        'source' => 'field',
        'targetPrefix' => 'field',
        'appFiles' => [
            'stubs/app/View/Components/Ui/Field.php' => 'app/View/Components/Ui/Field.php',
        ],
    ],
    'icon' => [
        'title' => 'Icon',
        'description' => 'Lucide icon dispatcher and built-in loading spinner.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
        'source' => 'icon',
        'targetPrefix' => 'icon',
    ],
    'input-group' => [
        'title' => 'Input Group',
        'description' => 'Layout shell for grouped input affixes.',
        'type' => 'registry:ui',
        'registryDependencies' => ['text'],
        'source' => 'input/group',
        'targetPrefix' => 'input/group',
    ],
    'input' => [
        'title' => 'Input',
        'description' => 'Accessible text input primitive with optional affixes, mask, password reveal, copy button, and character counter.',
        'type' => 'registry:ui',
        'registryDependencies' => ['input-group', 'field', 'icon'],
        'iconDependencies' => ['eye', 'clipboard'],
        'source' => 'input',
        'targetPrefix' => 'input',
        'filesOnly' => ['index.blade.php'],
        'assets' => [
            'resources/assets/js/input-enhancements.js' => 'input-enhancements.js',
        ],
    ],
    'input-currency' => [
        'title' => 'Input Currency',
        'description' => 'Currency input with locale-aware display and a hidden float value for form submission.',
        'type' => 'registry:ui',
        'registryDependencies' => ['field', 'input'],
        'source' => 'input',
        'targetPrefix' => 'input',
        'filesOnly' => ['currency.blade.php'],
        'assets' => [
            'resources/assets/js/input-currency.js' => 'input-currency.js',
        ],
    ],
    'text' => [
        'title' => 'Text',
        'description' => 'Body copy primitive with standardized size scale and automatic body font role.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
        'source' => 'text',
        'targetPrefix' => 'text',
        'filesOnly' => ['index.blade.php'],
    ],
    'heading' => [
        'title' => 'Heading',
        'description' => 'Semantic heading primitive with level-driven size scale and automatic heading font role.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
        'source' => 'heading',
        'targetPrefix' => 'heading',
        'filesOnly' => ['index.blade.php'],
    ],
    'button' => [
        'title' => 'Button',
        'description' => 'Composable button primitive with variants, sizes, link mode, and grouped layouts.',
        'type' => 'registry:ui',
        'registryDependencies' => ['icon'],
        'iconDependencies' => [],
        'source' => 'button',
        'targetPrefix' => 'button',
    ],
    'button-group' => [
        'title' => 'Button Group',
        'description' => 'Visual grouping for related buttons with shared borders, orientation, separators, and text affixes.',
        'type' => 'registry:ui',
        'registryDependencies' => ['button'],
        'source' => 'button-group',
        'targetPrefix' => 'button-group',
    ],
    'toggle' => [
        'title' => 'Toggle',
        'description' => 'Two-state pressed button control with outline/default variants and size scale.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
        'source' => 'toggle',
        'targetPrefix' => 'toggle',
        'assets' => [
            'resources/assets/js/toggle.js' => 'toggle.js',
        ],
    ],
    'toggle-group' => [
        'title' => 'Toggle Group',
        'description' => 'Single or multiple selection group of toggle items with toolbar/radiogroup semantics.',
        'type' => 'registry:ui',
        'registryDependencies' => ['toggle'],
        'source' => 'toggle-group',
        'targetPrefix' => 'toggle-group',
        'assets' => [
            'resources/assets/js/toggle-group.js' => 'toggle-group.js',
        ],
    ],
    'select' => [
        'title' => 'Select',
        'description' => 'Accessible custom listbox select with compound sub-components and optional Flux-style shortcut.',
        'type' => 'registry:ui',
        'registryDependencies' => ['icon'],
        'iconDependencies' => ['chevron-down', 'check', 'x'],
        'source' => 'select',
        'targetPrefix' => 'select',
        'assets' => [
            'resources/assets/js/select.js' => 'select.js',
        ],
    ],
    'combobox' => [
        'title' => 'Combobox',
        'description' => 'Accessible filterable combobox / autocomplete with single or multiple selection, chips, and compound sub-components.',
        'type' => 'registry:ui',
        'registryDependencies' => ['icon', 'text'],
        'iconDependencies' => ['chevron-down', 'check', 'x'],
        'source' => 'combobox',
        'targetPrefix' => 'combobox',
        'assets' => [
            'resources/assets/js/combobox.js' => 'combobox.js',
        ],
    ],
    'file-upload' => [
        'title' => 'File Upload',
        'description' => 'Accessible file upload with drag-and-drop dropzone, file list, and native multipart form support.',
        'type' => 'registry:ui',
        'registryDependencies' => ['icon', 'text', 'field'],
        'iconDependencies' => ['upload', 'file', 'x'],
        'source' => 'file-upload',
        'targetPrefix' => 'file-upload',
        'assets' => [
            'resources/assets/js/file-upload.js' => 'file-upload.js',
        ],
    ],
    'repeater' => [
        'title' => 'Repeater',
        'description' => 'Composition-first repeater for dynamic Laravel array fields with add/remove/duplicate rows, optional drag reorder, and native form submission.',
        'type' => 'registry:ui',
        'registryDependencies' => ['icon', 'text', 'field', 'input'],
        'iconDependencies' => ['plus', 'x', 'copy', 'grip-vertical'],
        'source' => 'repeater',
        'targetPrefix' => 'repeater',
        'assets' => [
            'resources/assets/js/repeater.js' => 'repeater.js',
        ],
    ],
    'pillbox' => [
        'title' => 'Pillbox',
        'description' => 'Free-text tags input that submits multiple strings as name[] with dedupe and optional max.',
        'type' => 'registry:ui',
        'registryDependencies' => ['icon', 'field'],
        'iconDependencies' => ['x'],
        'source' => 'pillbox',
        'targetPrefix' => 'pillbox',
        'assets' => [
            'resources/assets/js/pillbox.js' => 'pillbox.js',
        ],
    ],
    'rating' => [
        'title' => 'Rating',
        'description' => 'Accessible star rating input that submits a numeric value.',
        'type' => 'registry:ui',
        'registryDependencies' => ['icon', 'field'],
        'iconDependencies' => ['star'],
        'source' => 'rating',
        'targetPrefix' => 'rating',
        'assets' => [
            'resources/assets/js/rating.js' => 'rating.js',
        ],
    ],
    'color-picker' => [
        'title' => 'Color Picker',
        'description' => 'Native color input with optional synchronized hex text field.',
        'type' => 'registry:ui',
        'registryDependencies' => ['field', 'input'],
        'source' => 'color-picker',
        'targetPrefix' => 'color-picker',
        'assets' => [
            'resources/assets/js/color-picker.js' => 'color-picker.js',
        ],
    ],
    'input-otp' => [
        'title' => 'Input OTP',
        'description' => 'Accessible one-time password / PIN input with paste support, keyboard navigation, and a combined form value.',
        'type' => 'registry:ui',
        'registryDependencies' => ['field'],
        'source' => 'input-otp',
        'targetPrefix' => 'input-otp',
        'assets' => [
            'resources/assets/js/input-otp.js' => 'input-otp.js',
        ],
    ],
    'slider' => [
        'title' => 'Slider',
        'description' => 'Accessible slider and dual-thumb range control with keyboard support and a hidden form value.',
        'type' => 'registry:ui',
        'registryDependencies' => ['field'],
        'source' => 'slider',
        'targetPrefix' => 'slider',
        'assets' => [
            'resources/assets/js/slider.js' => 'slider.js',
        ],
    ],
    'textarea' => [
        'title' => 'Textarea',
        'description' => 'Accessible multi-line text control with autosize, character counter, validation, and disabled states.',
        'type' => 'registry:ui',
        'registryDependencies' => ['field'],
        'source' => 'textarea',
        'targetPrefix' => 'textarea',
        'filesOnly' => ['index.blade.php'],
        'assets' => [
            'resources/assets/js/textarea.js' => 'textarea.js',
        ],
    ],
    'checkbox' => [
        'title' => 'Checkbox',
        'description' => 'Native checkbox control with Stencil field surface and invalid states.',
        'type' => 'registry:ui',
        'registryDependencies' => ['field'],
        'source' => 'checkbox',
        'targetPrefix' => 'checkbox',
        'filesOnly' => ['index.blade.php'],
    ],
    'radio' => [
        'title' => 'Radio',
        'description' => 'Radio group and item primitives for single-choice form fields.',
        'type' => 'registry:ui',
        'registryDependencies' => ['field', 'label'],
        'source' => 'radio',
        'targetPrefix' => 'radio',
    ],
    'switch' => [
        'title' => 'Switch',
        'description' => 'Toggle switch control using role="switch" for binary settings.',
        'type' => 'registry:ui',
        'registryDependencies' => ['field'],
        'source' => 'switch',
        'targetPrefix' => 'switch',
        'filesOnly' => ['index.blade.php'],
    ],
    'dialog' => [
        'title' => 'Dialog',
        'description' => 'Accessible modal layer with compound sub-components, flyout mode, and named triggers.',
        'type' => 'registry:ui',
        'registryDependencies' => ['button', 'heading', 'text', 'icon'],
        'iconDependencies' => ['x'],
        'source' => 'dialog',
        'targetPrefix' => 'dialog',
        'assets' => [
            'resources/assets/js/dialog.js' => 'dialog.js',
        ],
    ],
    'command' => [
        'title' => 'Command',
        'description' => 'Accessible command palette with typeahead filtering, keyboard navigation, and optional dialog + ⌘K shortcut.',
        'type' => 'registry:ui',
        'registryDependencies' => ['dialog', 'icon'],
        'iconDependencies' => ['search', 'x'],
        'source' => 'command',
        'targetPrefix' => 'command',
        'assets' => [
            'resources/assets/js/command.js' => 'command.js',
        ],
    ],
    'accordion' => [
        'title' => 'Accordion',
        'description' => 'Accessible vertically stacked disclosures with exclusive or multiple open items.',
        'type' => 'registry:ui',
        'registryDependencies' => ['icon'],
        'iconDependencies' => ['chevron-down'],
        'source' => 'accordion',
        'targetPrefix' => 'accordion',
        'assets' => [
            'resources/assets/js/accordion.js' => 'accordion.js',
        ],
    ],
    'collapsible' => [
        'title' => 'Collapsible',
        'description' => 'Accessible single-panel expand/collapse primitive with optional transition.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
        'source' => 'collapsible',
        'targetPrefix' => 'collapsible',
        'assets' => [
            'resources/assets/js/collapsible.js' => 'collapsible.js',
        ],
    ],
    'sidebar' => [
        'title' => 'Sidebar',
        'description' => 'Composable app-shell sidebar with provider state, collapse modes, mobile overlay, and menu primitives.',
        'type' => 'registry:ui',
        'registryDependencies' => ['icon', 'button'],
        'iconDependencies' => ['panel-left'],
        'source' => 'sidebar',
        'targetPrefix' => 'sidebar',
        'assets' => [
            'resources/assets/js/sidebar.js' => 'sidebar.js',
        ],
    ],
    'avatar' => [
        'title' => 'Avatar',
        'description' => 'User image or initials with sizes, colors, circle mode, and grouped stacks.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
        'source' => 'avatar',
        'targetPrefix' => 'avatar',
        'assets' => [
            'resources/assets/js/avatar.js' => 'avatar.js',
        ],
    ],
    'badge' => [
        'title' => 'Badge',
        'description' => 'Compact status label with variants, colors, sizes, and optional close control.',
        'type' => 'registry:ui',
        'registryDependencies' => ['icon'],
        'iconDependencies' => ['x'],
        'source' => 'badge',
        'targetPrefix' => 'badge',
    ],
    'breadcrumb' => [
        'title' => 'Breadcrumb',
        'description' => 'Accessible navigation trail with links, separators, current page, and ellipsis.',
        'type' => 'registry:ui',
        'registryDependencies' => ['icon'],
        'iconDependencies' => ['chevron-right'],
        'source' => 'breadcrumb',
        'targetPrefix' => 'breadcrumb',
    ],
    'card' => [
        'title' => 'Card',
        'description' => 'Content container with header, title, description, content, action, and footer parts.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
        'source' => 'card',
        'targetPrefix' => 'card',
    ],
    'separator' => [
        'title' => 'Separator',
        'description' => 'Visual divider for horizontal or vertical layouts.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
        'source' => 'separator',
        'targetPrefix' => 'separator',
        'filesOnly' => ['index.blade.php'],
    ],
    'skeleton' => [
        'title' => 'Skeleton',
        'description' => 'Animated placeholder for loading states.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
        'source' => 'skeleton',
        'targetPrefix' => 'skeleton',
        'filesOnly' => ['index.blade.php'],
    ],
    'empty' => [
        'title' => 'Empty',
        'description' => 'Composable empty state with media, title, description, and content parts.',
        'type' => 'registry:ui',
        'registryDependencies' => [
            'icon',
        ],
        'source' => 'empty',
        'targetPrefix' => 'empty',
    ],
    'stepper' => [
        'title' => 'Stepper',
        'description' => 'Composable multi-step wizard indicator with panels and previous/next navigation.',
        'type' => 'registry:ui',
        'registryDependencies' => ['button', 'icon'],
        'iconDependencies' => ['check'],
        'source' => 'stepper',
        'targetPrefix' => 'stepper',
        'assets' => [
            'resources/assets/js/stepper.js' => 'stepper.js',
        ],
    ],
    'stat' => [
        'title' => 'Stat',
        'description' => 'Dashboard KPI card with label, value, description, trend, and optional icon.',
        'type' => 'registry:ui',
        'registryDependencies' => ['icon'],
        'source' => 'stat',
        'targetPrefix' => 'stat',
    ],
    'dropdown-menu' => [
        'title' => 'Dropdown Menu',
        'description' => 'Accessible action menu with trigger, items, groups, shortcuts, and keyboard navigation.',
        'type' => 'registry:ui',
        'registryDependencies' => ['button'],
        'source' => 'dropdown-menu',
        'targetPrefix' => 'dropdown-menu',
        'assets' => [
            'resources/assets/js/dropdown-menu.js' => 'dropdown-menu.js',
        ],
    ],
    'tabs' => [
        'title' => 'Tabs',
        'description' => 'Accessible tabbed panels with keyboard navigation and visual variants.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
        'source' => 'tabs',
        'targetPrefix' => 'tabs',
        'assets' => [
            'resources/assets/js/tabs.js' => 'tabs.js',
        ],
    ],
    'tooltip' => [
        'title' => 'Tooltip',
        'description' => 'Hover and focus tooltip for short contextual hints.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
        'source' => 'tooltip',
        'targetPrefix' => 'tooltip',
        'assets' => [
            'resources/assets/js/tooltip.js' => 'tooltip.js',
        ],
    ],
    'toast' => [
        'title' => 'Toast',
        'description' => 'Transient notifications with provider placement and JS helper API.',
        'type' => 'registry:ui',
        'registryDependencies' => ['icon'],
        'iconDependencies' => ['x'],
        'source' => 'toast',
        'targetPrefix' => 'toast',
        'assets' => [
            'resources/assets/js/toast.js' => 'toast.js',
        ],
    ],
    'progress' => [
        'title' => 'Progress',
        'description' => 'Determinate and indeterminate progress indicators.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
        'source' => 'progress',
        'targetPrefix' => 'progress',
        'filesOnly' => ['index.blade.php'],
    ],
    'alert' => [
        'title' => 'Alert',
        'description' => 'Inline callout for status, warnings, and informational messages.',
        'type' => 'registry:ui',
        'registryDependencies' => ['icon'],
        'source' => 'alert',
        'targetPrefix' => 'alert',
    ],
    'table' => [
        'title' => 'Table',
        'description' => 'Semantic data table primitives with header, body, footer, and caption.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
        'source' => 'table',
        'targetPrefix' => 'table',
    ],
    'pagination' => [
        'title' => 'Pagination',
        'description' => 'Page navigation controls with compound parts or a Laravel paginator shortcut.',
        'type' => 'registry:ui',
        'registryDependencies' => ['icon'],
        'iconDependencies' => ['chevron-left', 'chevron-right'],
        'source' => 'pagination',
        'targetPrefix' => 'pagination',
    ],

    'popover' => [
        'title' => 'Popover',
        'description' => 'Anchored floating panel with trigger, Escape/outside dismiss, and focus management.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
        'source' => 'popover',
        'targetPrefix' => 'popover',
        'assets' => [
            'resources/assets/js/popover.js' => 'popover.js',
        ],
    ],
    'calendar' => [
        'title' => 'Calendar',
        'description' => 'Accessible calendar grid for date and range selection.',
        'type' => 'registry:ui',
        'registryDependencies' => ['icon'],
        'iconDependencies' => ['chevron-left', 'chevron-right'],
        'source' => 'calendar',
        'targetPrefix' => 'calendar',
        'appFiles' => $chronoAppFiles,
        'assets' => [
            'resources/assets/js/calendar.js' => 'calendar.js',
            'resources/assets/js/chrono/date-value.js' => 'chrono/date-value.js',
            'resources/assets/js/chrono/parse.js' => 'chrono/parse.js',
            'resources/assets/js/chrono/timezone.js' => 'chrono/timezone.js',
        ],
    ],
    'date-picker' => [
        'title' => 'Date Picker',
        'description' => 'Date and range picker with presets, confirmation, and timezone-aware values.',
        'type' => 'registry:ui',
        'registryDependencies' => ['button', 'input', 'calendar', 'icon'],
        'iconDependencies' => ['calendar', 'x', 'chevron-down'],
        'source' => 'date-picker',
        'targetPrefix' => 'date-picker',
        'appFiles' => $chronoAppFiles,
        'assets' => [
            'resources/assets/js/date-picker.js' => 'date-picker.js',
            'resources/assets/js/calendar.js' => 'calendar.js',
            'resources/assets/js/chrono/date-value.js' => 'chrono/date-value.js',
            'resources/assets/js/chrono/parse.js' => 'chrono/parse.js',
            'resources/assets/js/chrono/timezone.js' => 'chrono/timezone.js',
            'resources/assets/js/chrono/popover.js' => 'chrono/popover.js',
        ],
    ],
    'time-picker' => [
        'title' => 'Time Picker',
        'description' => 'Time selection list with configurable steps and unavailable slots.',
        'type' => 'registry:ui',
        'registryDependencies' => ['input', 'icon'],
        'iconDependencies' => ['chevron-down'],
        'source' => 'time-picker',
        'targetPrefix' => 'time-picker',
        'assets' => [
            'resources/assets/js/time-picker.js' => 'time-picker.js',
            'resources/assets/js/chrono/popover.js' => 'chrono/popover.js',
            'resources/assets/js/chrono/timezone.js' => 'chrono/timezone.js',
        ],
    ],
    'datetime-picker' => [
        'title' => 'DateTime Picker',
        'description' => 'Combined date and time picker with ISO 8601 form values.',
        'type' => 'registry:ui',
        'registryDependencies' => ['button', 'calendar', 'date-picker'],
        'source' => 'datetime-picker',
        'targetPrefix' => 'datetime-picker',
        'appFiles' => $chronoAppFiles,
        'assets' => [
            'resources/assets/js/datetime-picker.js' => 'datetime-picker.js',
            'resources/assets/js/calendar.js' => 'calendar.js',
            'resources/assets/js/chrono/date-value.js' => 'chrono/date-value.js',
            'resources/assets/js/chrono/parse.js' => 'chrono/parse.js',
            'resources/assets/js/chrono/timezone.js' => 'chrono/timezone.js',
        ],
    ],
];

$indexItems = [];

foreach ($catalog as $name => $meta) {
    $source = $meta['source'] ?? $name;
    $targetPrefix = $meta['targetPrefix'] ?? $name;
    $sourceDir = $componentsPath.'/'.$source;

    if (! is_dir($sourceDir)) {
        fwrite(STDERR, "Missing component directory for catalog item [{$name}]: {$sourceDir}\n");
        exit(1);
    }

    $filesOnly = $meta['filesOnly'] ?? null;
    $files = collectBladeFiles($sourceDir, $targetPrefix, $filesOnly, $compiler);

    foreach ($meta['assets'] ?? [] as $packageRelative => $targetName) {
        $assetPath = $root.'/'.$packageRelative;
        $assetContent = file_get_contents($assetPath);

        if ($assetContent === false) {
            fwrite(STDERR, "Missing asset for [{$name}]: {$assetPath}\n");
            exit(1);
        }

        $assetTarget = rtrim($targetPrefix, '/').'/'.$targetName;

        $files[] = [
            'path' => $assetTarget,
            'type' => 'registry:ui',
            'target' => $assetTarget,
            'content' => $assetContent,
        ];
    }

    foreach ($meta['appFiles'] ?? [] as $sourceRelative => $target) {
        $appFilePath = $root.'/'.$sourceRelative;
        $appFileContent = file_get_contents($appFilePath);

        if ($appFileContent === false) {
            fwrite(STDERR, "Missing app file for [{$name}]: {$appFilePath}\n");
            exit(1);
        }

        if (str_ends_with($target, '.php')) {
            $appFileContent = $compiler->compilePhpSupport($appFileContent);
        }

        $files[] = [
            'path' => $target,
            'type' => 'registry:app',
            'target' => $target,
            'content' => $appFileContent,
        ];
    }

    if ($files === []) {
        fwrite(STDERR, "No Blade files found for [{$name}].\n");
        exit(1);
    }

    $item = [
        '$schema' => '../schema/registry-item.json',
        'name' => $name,
        'type' => $meta['type'],
        'title' => $meta['title'],
        'description' => $meta['description'],
        'registryDependencies' => $meta['registryDependencies'],
        'files' => $files,
    ];

    $iconDependencies = $meta['iconDependencies'] ?? [];

    if ($iconDependencies !== []) {
        $item['iconDependencies'] = $iconDependencies;
    }

    if (! is_dir($itemsPath)) {
        mkdir($itemsPath, 0755, true);
    }

    $itemPath = $itemsPath.'/'.$name.'.json';
    writeJson($itemPath, $item);

    $indexEntry = [
        'name' => $name,
        'type' => $meta['type'],
        'title' => $meta['title'],
        'description' => $meta['description'],
        'registryDependencies' => $meta['registryDependencies'],
    ];

    if ($iconDependencies !== []) {
        $indexEntry['iconDependencies'] = $iconDependencies;
    }

    $indexItems[] = $indexEntry;
}

$registry = [
    '$schema' => './schema/registry.json',
    'name' => 'ivanfuhr/stencil',
    'homepage' => 'https://github.com/ivanfuhr/stencil',
    'items' => $indexItems,
];

writeJson($registryPath.'/registry.json', $registry);

syncTestFixtures($registryPath, $root.'/tests/fixtures/registry');

fwrite(STDOUT, 'Registry built: '.count($indexItems).' items.'."\n");

/**
 * @param  list<string>|null  $filesOnly
 * @return list<array{path: string, type: string, target: string, content: string}>
 */
function collectBladeFiles(
    string $directory,
    string $targetPrefix,
    ?array $filesOnly,
    OwnedArtifactCompiler $compiler,
): array {
    $files = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS),
    );

    foreach ($iterator as $file) {
        if (! $file->isFile() || $file->getExtension() !== 'php') {
            continue;
        }

        $relative = substr($file->getPathname(), strlen($directory) + 1);
        $relative = str_replace('\\', '/', $relative);

        if ($filesOnly !== null && ! in_array($relative, $filesOnly, true)) {
            continue;
        }

        $target = $targetPrefix === '' ? $relative : rtrim($targetPrefix, '/').'/'.$relative;
        $content = file_get_contents($file->getPathname());

        if ($content === false) {
            continue;
        }

        $content = $compiler->compileBlade($content);

        $files[] = [
            'path' => $target,
            'type' => 'registry:ui',
            'target' => $target,
            'content' => $content,
        ];
    }

    usort($files, static fn (array $a, array $b): int => strcmp($a['target'], $b['target']));

    return $files;
}

function writeJson(string $path, array $data): void
{
    $encoded = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    if ($encoded === false) {
        fwrite(STDERR, "Failed to encode JSON for {$path}\n");
        exit(1);
    }

    file_put_contents($path, $encoded."\n");
}

function syncTestFixtures(string $registryPath, string $fixturePath): void
{
    if (! is_dir($fixturePath)) {
        mkdir($fixturePath, 0755, true);
    }

    copy($registryPath.'/registry.json', $fixturePath.'/registry.json');

    $itemsSource = $registryPath.'/items';
    $itemsTarget = $fixturePath.'/items';

    if (is_dir($itemsTarget)) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($itemsTarget, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST,
        );

        foreach ($iterator as $file) {
            if ($file->isDir()) {
                rmdir($file->getPathname());
            } else {
                unlink($file->getPathname());
            }
        }
    } else {
        mkdir($itemsTarget, 0755, true);
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($itemsSource, FilesystemIterator::SKIP_DOTS),
    );

    foreach ($iterator as $file) {
        if (! $file->isFile()) {
            continue;
        }

        $relative = substr($file->getPathname(), strlen($itemsSource) + 1);
        $target = $itemsTarget.'/'.$relative;
        $directory = dirname($target);

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        copy($file->getPathname(), $target);
    }
}
