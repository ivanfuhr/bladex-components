<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

it('registers the icon artisan command', function (): void {
    expect(Artisan::all())->toHaveKey('std:icon');
});

it('imports lucide icons into the default icons path', function (): void {
    $relativePath = 'storage/framework/testing/std-icons-'.getmypid();
    $iconsPath = app()->basePath($relativePath);

    if (is_dir($iconsPath)) {
        File::deleteDirectory($iconsPath);
    }

    Http::fake([
        'https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/search.svg' => Http::response(
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/></svg>',
            200,
        ),
    ]);

    Artisan::call('std:icon', [
        'names' => ['search'],
        '--path' => $relativePath,
    ]);

    expect(Artisan::output())->toContain('search: written');

    $target = $iconsPath.'/search.blade.php';

    expect(is_file($target))->toBeTrue()
        ->and(file_get_contents($target))->toContain('icon.lucide');

    File::deleteDirectory($iconsPath);
});

it('renders the packaged loading icon', function (): void {
    $html = Blade::render('<x-std::icon.loading class="text-zinc-500" />');

    expect($html)
        ->toContain('data-icon')
        ->toContain('width="16"')
        ->toContain('height="16"')
        ->toContain('animate-spin')
        ->toContain('text-zinc-500');
});

it('renders a dynamic icon wrapper for packaged icons', function (): void {
    $html = Blade::render('<x-std::icon name="search" />');

    expect($html)->toContain('data-icon');
});
