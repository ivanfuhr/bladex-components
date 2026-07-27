<?php

declare(strict_types=1);

/**
 * Build registry JSON from package Blade sources under resources/views/components.
 *
 * Usage: php scripts/build-registry.php
 */
$root = dirname(__DIR__);

require $root.'/vendor/autoload.php';

use Ivanfuhr\BladexComponents\Registry\OwnedArtifactCompiler;

$componentsPath = $root.'/resources/views/components';
$registryPath = $root.'/registry';
$itemsPath = $registryPath.'/items';
$compiler = new OwnedArtifactCompiler;

if (! is_dir($componentsPath)) {
    fwrite(STDERR, "Components path not found: {$componentsPath}\n");
    exit(1);
}

/** @var array<string, array{title: string, description: string, type: string, registryDependencies: list<string>, source?: string, targetPrefix?: string, filesOnly?: list<string>, assets?: array<string, string>}> $catalog */
$catalog = [
    'field' => [
        'title' => 'Field Message',
        'description' => 'Hint and error message primitive for form fields.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
        'source' => 'field',
        'targetPrefix' => 'field',
        'filesOnly' => ['message.blade.php', 'errors.blade.php'],
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
    'name' => 'ivanfuhr/bladex-components',
    'homepage' => 'https://github.com/ivanfuhr/bladex-components',
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
