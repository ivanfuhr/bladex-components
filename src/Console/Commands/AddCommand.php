<?php

declare(strict_types=1);

namespace Ivanfuhr\BladexComponents\Console\Commands;

use Ivanfuhr\BladexComponents\Registry\ComponentInstaller;
use Ivanfuhr\BladexComponents\Registry\RegistryClient;
use Ivanfuhr\BladexComponents\Registry\RegistryResolver;
use Ivanfuhr\BladexComponents\Support\ProjectConfig;
use Ivanfuhr\BladexComponents\Support\ProjectLock;
use Throwable;

class AddCommand extends RegistryCommand
{
    protected $signature = 'bladex-components:add
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
    ): int {
        if (! $projectConfig->exists()) {
            $this->components->error('Project config not found. Run bladex-components:init first.');

            return self::FAILURE;
        }

        $names = $this->argument('names');

        if (! is_array($names) || $names === []) {
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

        if ($dryRun) {
            $this->components->info('Dry run complete. No files were written.');
        } else {
            $this->components->info('Registry items installed.');
        }

        return self::SUCCESS;
    }
}
