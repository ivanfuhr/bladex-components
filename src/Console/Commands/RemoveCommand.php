<?php

declare(strict_types=1);

namespace Ivanfuhr\BladexComponents\Console\Commands;

use Ivanfuhr\BladexComponents\Registry\ComponentInstaller;
use Ivanfuhr\BladexComponents\Support\ProjectConfig;
use Ivanfuhr\BladexComponents\Support\ProjectLock;
use Throwable;

class RemoveCommand extends RegistryCommand
{
    protected $signature = 'bladex-components:remove
                            {names* : Registry item names to remove}
                            {--keep-files : Remove lock entries without deleting files}';

    protected $description = 'Remove installed registry UI components.';

    public function handle(
        ProjectConfig $projectConfig,
        ProjectLock $projectLock,
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

        $keepFiles = (bool) $this->option('keep-files');

        foreach ($names as $name) {
            if (! is_string($name)) {
                continue;
            }

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

        $this->components->info('Remove complete.');

        return self::SUCCESS;
    }
}
