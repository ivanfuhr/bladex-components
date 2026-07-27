<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Console\Commands;

use Ivanfuhr\Stencil\Registry\ComponentInstaller;
use Ivanfuhr\Stencil\Registry\ProjectIntegrator;
use Ivanfuhr\Stencil\Support\ProjectConfig;
use Ivanfuhr\Stencil\Support\ProjectLock;
use Throwable;

class RemoveCommand extends RegistryCommand
{
    protected $signature = 'stencil:remove
                            {names* : Registry item names to remove}
                            {--keep-files : Remove lock entries without deleting files}';

    protected $description = 'Remove installed registry UI components.';

    public function handle(
        ProjectConfig $projectConfig,
        ProjectLock $projectLock,
        ComponentInstaller $installer,
        ProjectIntegrator $integrator,
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

        $keepFiles = (bool) $this->option('keep-files');

        foreach ($names as $name) {
            try {
                $removed = $installer->remove($projectConfig, $projectLock, $name, $keepFiles);
            } catch (Throwable $exception) {
                $this->components->error("[{$name}] {$exception->getMessage()}");

                return self::FAILURE;
            }

            if ($removed === []) {
                $this->line("{$name}: nothing to remove.");

                continue;
            }

            foreach ($removed as $path) {
                $this->line($keepFiles ? 'Unlocked '.$path : 'Removed '.$path);
            }
        }

        $integrator->syncFromLock($projectConfig, $projectLock);

        $this->components->info('Remove complete.');

        return self::SUCCESS;
    }
}
