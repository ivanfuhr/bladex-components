<?php

declare(strict_types=1);

/**
 * Remove @props([...]) blocks from Blade views (props live on class components).
 *
 * Usage: php scripts/strip-blade-props.php
 */
$root = dirname(__DIR__);
$viewsRoot = $root.'/resources/views/components';

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($viewsRoot, FilesystemIterator::SKIP_DOTS),
);

$updated = 0;

foreach ($iterator as $file) {
    if (! $file->isFile() || ! str_ends_with($file->getFilename(), '.blade.php')) {
        continue;
    }

    $path = $file->getPathname();
    $contents = file_get_contents($path);

    if ($contents === false) {
        continue;
    }

    $stripped = preg_replace('/@props\(\[[\s\S]*?\]\)\s*\n?/', '', $contents, 1);

    if ($stripped !== $contents) {
        file_put_contents($path, $stripped);
        $updated++;
    }
}

echo "Stripped @props from {$updated} blade files.\n";
