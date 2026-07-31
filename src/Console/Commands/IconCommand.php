<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Ivanfuhr\Stencil\Support\Icon\IconPathResolver;
use Ivanfuhr\Stencil\Support\Icon\LucideIconInstaller;
use Ivanfuhr\Stencil\Support\ProjectConfig;
use Throwable;

use function Laravel\Prompts\text;

class IconCommand extends Command
{
    protected $signature = 'stencil:icon
                            {names?* : Lucide icon names to import (see lucide.dev/icons)}
                            {--force : Overwrite existing icon stubs}
                            {--path= : Destination directory relative to the application base path}';

    protected $description = 'Import Lucide icons as Blade components under resources/views/ui/icons.';

    public function handle(
        ProjectConfig $projectConfig,
        IconPathResolver $pathResolver,
        LucideIconInstaller $installer,
    ): int {
        $names = $this->resolveNames();

        if ($names === []) {
            $this->components->error('Provide at least one icon name.');

            return self::FAILURE;
        }

        if (! $projectConfig->exists()) {
            $this->components->warn('stencil.json was not found. Using default icon path from config.');
            $this->line('Run stencil:init to align paths.icons with your project.');
        }

        $pathOption = $this->option('path');
        $directory = $pathResolver->resolveWritePath(is_string($pathOption) && $pathOption !== '' ? $pathOption : null);
        $force = (bool) $this->option('force');

        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $failures = 0;

        foreach ($names as $name) {
            try {
                $normalized = IconPathResolver::normalizeName($name);
                $target = $pathResolver->iconFilePath($normalized, $directory);

                if (is_file($target) && ! $force) {
                    $this->components->warn("{$normalized}: already exists (use --force to overwrite).");

                    continue;
                }

                $written = $installer->install([$normalized], $force, false, $directory);

                if ($written === []) {
                    continue;
                }

                $this->components->info("{$normalized}: written to {$target}");
            } catch (Throwable $exception) {
                $this->components->error("[{$name}] {$exception->getMessage()}");
                $failures++;
            }
        }

        return $failures > 0 ? self::FAILURE : self::SUCCESS;
    }

    /**
     * @return list<string>
     */
    private function resolveNames(): array
    {
        $argument = $this->argument('names');

        if ($argument !== []) {
            return array_values($argument);
        }

        if (! $this->input->isInteractive()) {
            return [];
        }

        $input = text(
            label: 'Icon names (comma-separated)',
            placeholder: 'search, grip-vertical, github',
            required: true,
        );

        if (trim($input) === '') {
            return [];
        }

        $parts = preg_split('/\s*,\s*/', trim($input)) ?: [];

        return array_values(array_filter($parts, static fn (string $part): bool => $part !== ''));
    }
}
