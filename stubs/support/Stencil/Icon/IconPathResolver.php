<?php

declare(strict_types=1);

namespace App\Support\Stencil\Icon;

use Illuminate\Contracts\Foundation\Application;
use InvalidArgumentException;
use App\Support\Stencil\ProjectConfig;

final class IconPathResolver
{
    public function __construct(
        private readonly Application $app,
        private readonly ProjectConfig $projectConfig,
    ) {}

    public function resolveWritePath(?string $override = null): string
    {
        if ($override !== null && $override !== '') {
            return $this->app->basePath($override);
        }

        return $this->projectConfig->resolvedIconsPath();
    }

    public function iconFilePath(string $name, ?string $directory = null): string
    {
        $normalized = self::normalizeName($name);

        return rtrim($directory ?? $this->resolveWritePath(), DIRECTORY_SEPARATOR)
            .DIRECTORY_SEPARATOR
            .$normalized.'.blade.php';
    }

    public static function normalizeName(string $name): string
    {
        $trimmed = trim($name);

        if ($trimmed === '') {
            throw new InvalidArgumentException('Icon name cannot be empty.');
        }

        $normalized = strtolower(str_replace('_', '-', $trimmed));

        if (! preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $normalized)) {
            throw new InvalidArgumentException("Invalid icon name [{$name}]. Use kebab-case names from lucide.dev/icons.");
        }

        return $normalized;
    }

    public function lucideUrl(string $name): string
    {
        $template = (string) config(
            'stencil-ui.lucide_raw_url',
            'https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/{name}.svg',
        );

        return str_replace('{name}', self::normalizeName($name), $template);
    }
}
