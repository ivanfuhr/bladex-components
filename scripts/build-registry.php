<?php

declare(strict_types=1);

/**
 * Build registry JSON from package Blade sources under resources/views/components.
 *
 * Usage: php scripts/build-registry.php
 */
$root = dirname(__DIR__);
$componentsPath = $root.'/resources/views/components';
$registryPath = $root.'/registry';
$itemsPath = $registryPath.'/items';

if (! is_dir($componentsPath)) {
    fwrite(STDERR, "Components path not found: {$componentsPath}\n");
    exit(1);
}

/** @var array<string, array{title: string, description: string, type: string, registryDependencies: list<string>, source?: string, targetPrefix?: string}> $catalog */
$catalog = [
    'input-group' => [
        'title' => 'Input Group',
        'description' => 'Layout shell for grouped input affixes.',
        'type' => 'registry:ui',
        'registryDependencies' => [],
        'source' => 'input/group',
        'targetPrefix' => 'input/group',
    ],
    'input' => [
        'title' => 'Input',
        'description' => 'Accessible text input primitive with optional affixes and group layout.',
        'type' => 'registry:ui',
        'registryDependencies' => ['input-group'],
        'source' => 'input',
        'targetPrefix' => 'input',
        'filesOnly' => ['index.blade.php'],
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
    $files = collectBladeFiles($sourceDir, $targetPrefix, $filesOnly);

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

fwrite(STDOUT, 'Registry built: '.count($indexItems).' items.'."\n");

/**
 * @param  list<string>|null  $filesOnly
 * @return list<array{path: string, type: string, target: string, content: string}>
 */
function collectBladeFiles(string $directory, string $targetPrefix, ?array $filesOnly = null): array
{
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
