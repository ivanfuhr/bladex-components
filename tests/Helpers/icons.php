<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Http;
use Ivanfuhr\StdComponents\Support\Icon\IconPathResolver;

/**
 * @return list<string>
 */
function defaultStdTestIconNames(): array
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

/**
 * Ensure shipped package icons exist for tests.
 *
 * Never write stub SVGs into resources/views/icons — that polluted upload.blade.php
 * with a placeholder vertical line that shipped as a "real" Lucide icon.
 *
 * @param  list<string>|null  $names
 */
function seedStdTestIcons(?array $names = null): void
{
    $names = $names ?? defaultStdTestIconNames();
    $iconsPath = dirname(__DIR__, 2).'/resources/views/icons';

    foreach ($names as $name) {
        $normalized = IconPathResolver::normalizeName($name);
        $target = $iconsPath.'/'.$normalized.'.blade.php';

        if (! is_file($target)) {
            throw new RuntimeException(
                "Missing package icon [{$normalized}] at {$target}. Restore the Lucide stub under resources/views/icons.",
            );
        }
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
