<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Support\Icon;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use RuntimeException;

final class LucideIconInstaller
{
    public function __construct(
        private readonly Application $app,
        private readonly IconPathResolver $pathResolver,
        private readonly LucideIconStubGenerator $generator,
    ) {}

    /**
     * @param  list<string>  $names
     * @return list<string> app-relative icon paths written or that would be written
     */
    public function install(
        array $names,
        bool $overwrite = false,
        bool $dryRun = false,
        ?string $directory = null,
    ): array {
        $directory ??= $this->pathResolver->resolveWritePath(null);
        $written = [];

        if (! File::isDirectory($directory) && ! $dryRun) {
            File::makeDirectory($directory, 0755, true);
        }

        foreach ($names as $name) {
            $normalized = IconPathResolver::normalizeName($name);
            $target = $this->pathResolver->iconFilePath($normalized, $directory);
            $appRelative = $this->appRelativePath($target);

            if (is_file($target) && ! $overwrite) {
                continue;
            }

            $url = $this->pathResolver->lucideUrl($normalized);
            $response = Http::timeout(15)->get($url);

            if ($response->status() === 404) {
                throw new RuntimeException("Icon [{$normalized}] was not found at Lucide ({$url}).");
            }

            if (! $response->successful()) {
                throw new RuntimeException("Icon [{$normalized}] failed to download (HTTP {$response->status()}).");
            }

            $stub = $this->generator->generate($normalized, $response->body());

            if (! $dryRun) {
                File::ensureDirectoryExists(dirname($target));
                File::put($target, $stub);
            }

            $written[] = $appRelative;
        }

        return $written;
    }

    private function appRelativePath(string $absolutePath): string
    {
        $base = rtrim($this->app->basePath(), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

        if (str_starts_with($absolutePath, $base)) {
            return str_replace('\\', '/', substr($absolutePath, strlen($base)));
        }

        return str_replace('\\', '/', $absolutePath);
    }
}
