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

/** @var array<string, array{title: string, description: string, type: string, registryDependencies: list<string>, source?: string, targetPrefix?: string, filesOnly?: list<string>, assets?: array<string, string>}> $catalog */
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
        'description' => 'Accessible text input primitive with optional affixes and group layout.',
        'type' => 'registry:ui',
        'registryDependencies' => ['input-group', 'field'],
        'source' => 'input',
        'targetPrefix' => 'input',
        'filesOnly' => ['index.blade.php'],
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
        'registryDependencies' => [],
        'source' => 'button',
        'targetPrefix' => 'button',
    ],
    'select' => [
        'title' => 'Select',
        'description' => 'Accessible custom listbox select with compound sub-components and optional Flux-style shortcut.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
        'source' => 'select',
        'targetPrefix' => 'select',
        'assets' => [
            'resources/assets/js/select.js' => 'select.js',
        ],
    ],
    'textarea' => [
        'title' => 'Textarea',
        'description' => 'Accessible multi-line text control with validation and disabled states.',
        'type' => 'registry:ui',
        'registryDependencies' => ['field', 'text'],
        'source' => 'textarea',
        'targetPrefix' => 'textarea',
        'filesOnly' => ['index.blade.php'],
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
        'registryDependencies' => ['button'],
        'source' => 'dialog',
        'targetPrefix' => 'dialog',
        'assets' => [
            'resources/assets/js/dialog.js' => 'dialog.js',
        ],
    ],
    'popover' => [
        'title' => 'Popover',
        'description' => 'Anchored floating panel primitive for overlays.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
        'source' => 'popover',
        'targetPrefix' => 'popover',
        'filesOnly' => ['index.blade.php'],
    ],
    'calendar' => [
        'title' => 'Calendar',
        'description' => 'Accessible calendar grid for date and range selection.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
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
        'registryDependencies' => ['button', 'input', 'calendar'],
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
        'registryDependencies' => ['input'],
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

    if (! is_dir($itemsPath)) {
        mkdir($itemsPath, 0755, true);
    }

    $itemPath = $itemsPath.'/'.$name.'.json';
    writeJson($itemPath, $item);

    $indexItems[] = [
        'name' => $name,
        'type' => $meta['type'],
        'title' => $meta['title'],
        'description' => $meta['description'],
        'registryDependencies' => $meta['registryDependencies'],
    ];
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
