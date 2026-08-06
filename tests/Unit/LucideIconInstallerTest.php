<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Ivanfuhr\StdComponents\Support\Icon\LucideIconInstaller;

it('downloads and writes lucide icon stubs', function (): void {
    $relativePath = 'storage/framework/testing/lucide-installer-'.getmypid();
    $directory = app()->basePath($relativePath);

    Http::fake([
        'https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/search.svg' => Http::response(
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/></svg>',
            200,
        ),
    ]);

    $installer = app(LucideIconInstaller::class);
    $written = $installer->install(['search'], false, false, $directory);

    expect($written)->toHaveCount(1)
        ->and(is_file($directory.'/search.blade.php'))->toBeTrue();

    File::deleteDirectory($directory);
});

it('skips existing lucide icon stubs unless overwrite is enabled', function (): void {
    $relativePath = 'storage/framework/testing/lucide-installer-skip-'.getmypid();
    $directory = app()->basePath($relativePath);
    $target = $directory.'/search.blade.php';

    File::ensureDirectoryExists($directory);
    file_put_contents($target, 'existing');

    Http::fake();

    $installer = app(LucideIconInstaller::class);

    expect($installer->install(['search'], false, false, $directory))->toBe([])
        ->and(file_get_contents($target))->toBe('existing');

    File::deleteDirectory($directory);
});
