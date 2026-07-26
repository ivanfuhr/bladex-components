<?php

declare(strict_types=1);

use Illuminate\Http\Client\Factory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Ivanfuhr\BladexComponents\Support\Icon\LucideIconStubGenerator;
use Ivanfuhr\BladexComponents\Support\ProjectConfig;

afterEach(function (): void {
    Http::swap(new Factory);
});

it('registers the icon artisan command', function (): void {
    expect(Artisan::all())->toHaveKey('bladex-components:icon');
});

it('imports lucide icons into the default icons path', function (): void {
    $relativePath = 'storage/framework/testing/bladex-icons-'.getmypid();
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

    Artisan::call('bladex-components:icon', [
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
    $html = Blade::render('<x-bladex-components::icon.loading class="text-zinc-500" />');

    expect($html)
        ->toContain('data-icon')
        ->toContain('width="16"')
        ->toContain('height="16"')
        ->toContain('animate-spin')
        ->toContain('text-zinc-500');
});

it('renders an imported ui icon and dynamic wrapper', function (): void {
    $relativeUi = 'storage/framework/testing/ui-render-'.getmypid();
    $relativeIcons = $relativeUi.'/icons';
    $iconsPath = app()->basePath($relativeIcons);
    $uiPath = app()->basePath($relativeUi);

    File::ensureDirectoryExists($iconsPath);

    $configPath = app()->basePath('bladex-components.json');
    $hadConfig = is_file($configPath);
    $previousConfig = $hadConfig ? file_get_contents($configPath) : null;

    file_put_contents($configPath, json_encode([
        'registry' => config('bladex-components.default_registry_url'),
        'paths' => [
            'ui' => $relativeUi,
            'icons' => $relativeIcons,
        ],
    ], JSON_THROW_ON_ERROR)."\n");

    $stub = (new LucideIconStubGenerator)->generate(
        'bolt',
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M13 2 3 14h9"/></svg>',
    );

    file_put_contents($iconsPath.'/bolt.blade.php', $stub);

    Blade::anonymousComponentPath($uiPath, 'ui');

    $direct = Blade::render('<x-ui::icons.bolt />');
    $dynamic = Blade::render('<x-bladex-components::icon name="bolt" />');

    expect($direct)->toContain('data-icon')
        ->and($dynamic)->toContain('data-icon');

    File::deleteDirectory($iconsPath);

    if ($hadConfig && is_string($previousConfig)) {
        file_put_contents($configPath, $previousConfig);
    } else {
        @unlink($configPath);
    }

    Artisan::call('view:clear');
});

it('resolves icons path from project config when present', function (): void {
    $base = app()->basePath();
    $configPath = $base.'/bladex-components.json';

    file_put_contents($configPath, json_encode([
        'registry' => 'package://registry.json',
        'paths' => [
            'ui' => 'resources/views/ui',
            'icons' => 'resources/views/custom-icons',
        ],
    ], JSON_THROW_ON_ERROR));

    $projectConfig = new ProjectConfig(app());

    expect($projectConfig->iconsPath())->toBe('resources/views/custom-icons');

    @unlink($configPath);
});
