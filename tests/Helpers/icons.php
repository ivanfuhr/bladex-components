<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Ivanfuhr\Stencil\Support\Icon\IconPathResolver;
use Ivanfuhr\Stencil\Support\Icon\LucideIconStubGenerator;

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
        'clock',
        'copy',
        'eye',
        'file',
        'grip-vertical',
        'panel-left',
        'plus',
        'star',
        'search',
        'upload',
        'x',
    ];
}

function seedStencilTestIcons(?array $names = null): void
{
    $names = $names ?? defaultStencilTestIconNames();
    $iconsPath = dirname(__DIR__, 2).'/resources/views/icons';

    File::ensureDirectoryExists($iconsPath);

    $generator = new LucideIconStubGenerator;
    $minimalSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2v20"/></svg>';

    foreach ($names as $name) {
        $normalized = IconPathResolver::normalizeName($name);
        $target = $iconsPath.'/'.$normalized.'.blade.php';

        if (is_file($target)) {
            continue;
        }

        file_put_contents($target, $generator->generate($normalized, $minimalSvg));
    }
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
