<?php

declare(strict_types=1);

namespace Ivanfuhr\BladexComponents\Console\Commands;

use Ivanfuhr\BladexComponents\Registry\ComponentInstaller;
use Ivanfuhr\BladexComponents\Registry\RegistryClient;
use Ivanfuhr\BladexComponents\Support\ProjectConfig;
use Ivanfuhr\BladexComponents\Support\ProjectLock;
use Throwable;

class UpdateCommand extends RegistryCommand
{
    protected $signature = 'bladex-components:update
                            {name? : Optional registry item name to update}
                            {--overwrite : Replace files that were modified locally}';

    protected $description = 'Update installed registry UI components from the remote registry.';

    public function handle(
        ProjectConfig $projectConfig,
        ProjectLock $projectLock,
        RegistryClient $registryClient,
        ComponentInstaller $installer,
    ): int {
        if (! $projectConfig->exists()) {
            $this->components->error('Project config not found. Run bladex-components:init first.');

            return self::FAILURE;
        }

        if ($projectLock->installedNames() === []) {
            $this->components->warn('No installed registry items found.');

            return self::SUCCESS;
        }

        $name = $this->argument('name');
        $onlyName = is_string($name) ? $name : null;

        try {
            $result = $installer->update(
                $projectConfig,
                $projectLock,
                $registryClient,
                $onlyName,
                (bool) $this->option('overwrite'),
            );
        } catch (Throwable $exception) {
            $this->components->error($exception->getMessage());

            return self::FAILURE;
        }

        foreach ($result['updated'] as $path) {
            $this->line('Updated '.$path);
        }

        foreach ($result['skipped'] as $path) {
            $this->line('Skipped '.$path.' (already up to date)');
        }

        foreach ($result['modified_locally'] as $path) {
            $this->warn('Modified locally: '.$path.' (use --overwrite to replace)');
        }

        if ($result['updated'] === [] && $result['modified_locally'] === []) {
            $this->components->info('Nothing to update.');
        }

        return self::SUCCESS;
    }
}
