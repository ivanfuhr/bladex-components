<?php

declare(strict_types=1);

/**
 * Restore @props blocks from git for blades that still use @php logic.
 *
 * Usage: php scripts/restore-blade-props-from-git.php
 */
$root = dirname(__DIR__);
$viewsRoot = $root.'/resources/views/components';

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($viewsRoot, FilesystemIterator::SKIP_DOTS),
);

$restored = 0;

foreach ($iterator as $file) {
    if (! $file->isFile() || ! str_ends_with($file->getFilename(), '.blade.php')) {
        continue;
    }

    $path = $file->getPathname();
    $contents = file_get_contents($path);

    if ($contents === false || ! str_contains($contents, '@php')) {
        continue;
    }

    if (str_contains($contents, '@props(')) {
        continue;
    }

    $relative = str_replace($root.'/', '', $path);
    $gitPath = escapeshellarg($relative);
    $original = shell_exec('cd '.escapeshellarg($root)." && git show HEAD:{$gitPath} 2>/dev/null");

    if (! is_string($original) || ! preg_match('/@props\(\[[\s\S]*?\]\)\s*\n?/', $original, $match)) {
        continue;
    }

    $updated = $match[0]."\n".$contents;
    file_put_contents($path, $updated);
    $restored++;
}

echo "Restored @props on {$restored} blade files.\n";
