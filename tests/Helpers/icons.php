<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Ivanfuhr\Stencil\Support\Icon\IconPathResolver;
use Ivanfuhr\Stencil\Support\Icon\LucideIconStubGenerator;
use Ivanfuhr\Stencil\Support\ProjectConfig;

/**
 * @return list<string>
 */
function defaultStencilTestIconNames(): array
{
    return [
        'calendar',
        'check',
        'chevron-down',
        'chevron-left',
        'chevron-right',
        'clipboard',
        'copy',
        'eye',
        'file',
        'grip-vertical',
        'plus',
        'star',
        'upload',
        'x',
    ];
}

function stencilTestWorkerUiRelativePath(): string
{
    $token = getenv('TEST_TOKEN');

    if ($token !== false && $token !== '') {
        return 'storage/framework/testing/stencil-ui-'.$token;
    }

    return 'storage/framework/testing/stencil-ui-'.getmypid();
}

function stencilTestConfigRelativePath(): string
{
    $token = getenv('TEST_TOKEN');

    if ($token !== false && $token !== '') {
        return 'storage/framework/testing/stencil-'.$token.'.json';
    }

    return 'storage/framework/testing/stencil-'.getmypid().'.json';
}

function ensureStencilTestProjectConfig(): void
{
    $ui = stencilTestWorkerUiRelativePath();
    $icons = $ui.'/icons';
    $configPath = app(ProjectConfig::class)->path();

    File::ensureDirectoryExists(dirname($configPath));

    file_put_contents($configPath, json_encode([
        'registry' => config('stencil.default_registry_url'),
        'paths' => [
            'ui' => $ui,
            'icons' => $icons,
        ],
    ], JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES)."\n");

    app()->forgetInstance(ProjectConfig::class);
}

function seedStencilTestIcons(?array $names = null): void
{
    $names = $names ?? defaultStencilTestIconNames();

    ensureStencilTestProjectConfig();

    $projectConfig = app(ProjectConfig::class);
    $uiPath = $projectConfig->resolvedUiPath();
    $iconsPath = $projectConfig->resolvedIconsPath();

    File::ensureDirectoryExists($iconsPath);

    $generator = new LucideIconStubGenerator;
    $minimalSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2v20"/></svg>';

    foreach ($names as $name) {
        $normalized = IconPathResolver::normalizeName($name);
        $target = $iconsPath.'/'.$normalized.'.blade.php';
        file_put_contents($target, $generator->generate($normalized, $minimalSvg));
    }

    Blade::anonymousComponentPath($uiPath, 'ui');
}

function fakeLucideIconHttp(): void
{
    Http::fake([
        'https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/*.svg' => Http::response(
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2v20"/></svg>',
            200,
        ),
    ]);
}
