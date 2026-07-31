<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Console\Commands;

use Ivanfuhr\Stencil\Registry\ComponentInstaller;
use Ivanfuhr\Stencil\Registry\ProjectIntegrator;
use Ivanfuhr\Stencil\Registry\RegistryClient;
use Ivanfuhr\Stencil\Registry\RegistryResolver;
use Ivanfuhr\Stencil\Support\Icon\IconPathResolver;
use Ivanfuhr\Stencil\Support\Icon\LucideIconInstaller;
use Ivanfuhr\Stencil\Support\ProjectConfig;
use Ivanfuhr\Stencil\Support\ProjectLock;
use Throwable;

class AddCommand extends RegistryCommand
{
    protected $signature = 'stencil:add
                            {names* : Registry item names to install}
                            {--overwrite : Replace files that differ from the registry}
                            {--dry-run : Resolve dependencies and show files without writing}';

    protected $description = 'Install registry UI components into resources/views/ui.';

    public function handle(
        ProjectConfig $projectConfig,
        ProjectLock $projectLock,
        RegistryClient $registryClient,
        RegistryResolver $registryResolver,
        ComponentInstaller $installer,
        ProjectIntegrator $integrator,
        LucideIconInstaller $iconInstaller,
        IconPathResolver $pathResolver,
    ): int {
        if (! $projectConfig->exists()) {
            $this->components->error('Project config not found. Run stencil:init first.');

            return self::FAILURE;
        }

        $names = $this->argument('names');

        if ($names === []) {
            $this->components->error('Provide at least one registry item name.');

            return self::FAILURE;
        }

        $registryUrl = $projectConfig->registryUrl();

        try {
            $index = $registryClient->fetchIndex($registryUrl);
            $items = $registryResolver->resolve($registryUrl, $index['items'], array_values($names));
        } catch (Throwable $exception) {
            $this->components->error($exception->getMessage());

            return self::FAILURE;
        }

        $overwrite = (bool) $this->option('overwrite');
        $dryRun = (bool) $this->option('dry-run');

        foreach ($items as $item) {
            $name = (string) ($item['name'] ?? 'unknown');

            try {
                $written = $installer->install(
                    $projectConfig,
                    $projectLock,
                    $item,
                    $registryUrl,
                    $overwrite,
                    $dryRun,
                );
            } catch (Throwable $exception) {
                $this->components->error("[{$name}] {$exception->getMessage()}");

                return self::FAILURE;
            }

            if ($written === []) {
                $this->line("{$name}: no changes.");

                continue;
            }

            foreach ($written as $path) {
                $prefix = $dryRun ? 'Would add ' : 'Added ';
                $this->line($prefix.$path);
            }
        }

        $iconNames = $this->collectIconDependencies($items);

        if ($iconNames !== []) {
            try {
                $writtenIcons = $iconInstaller->installForProject($iconNames, $overwrite, $dryRun);
            } catch (Throwable $exception) {
                $this->components->error($exception->getMessage());

                return self::FAILURE;
            }

            foreach ($iconNames as $iconName) {
                $normalized = IconPathResolver::normalizeName($iconName);
                $target = $pathResolver->iconFilePath($normalized);

                if (in_array($this->appRelativePath($projectConfig, $target), $writtenIcons, true)) {
                    $prefix = $dryRun ? 'Would add icon ' : 'Added icon ';
                    $this->line($prefix.$normalized);
                }
            }
        }

        if ($dryRun) {
            $this->components->info('Dry run complete. No files were written.');
        } else {
            $integrator->syncFromLock($projectConfig, $projectLock);
            $this->components->info('Registry items installed.');
        }

        return self::SUCCESS;
    }

    /**
     * @param  list<array<string, mixed>>  $items
     * @return list<string>
     */
    private function collectIconDependencies(array $items): array
    {
        $icons = [];

        foreach ($items as $item) {
            $dependencies = $item['iconDependencies'] ?? [];

            if (! is_array($dependencies)) {
                continue;
            }

            foreach ($dependencies as $dependency) {
                if (is_string($dependency) && $dependency !== '') {
                    $icons[] = $dependency;
                }
            }
        }

        return array_values(array_unique($icons));
    }

    private function appRelativePath(ProjectConfig $config, string $absolutePath): string
    {
        $base = rtrim($config->basePath(), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

        if (str_starts_with($absolutePath, $base)) {
            return str_replace('\\', '/', substr($absolutePath, strlen($base)));
        }

        return str_replace('\\', '/', $absolutePath);
    }
}
