<?php

declare(strict_types=1);

namespace Ivanfuhr\BladexComponents\Console\Commands;

use Ivanfuhr\BladexComponents\Registry\ProjectScaffolder;
use Ivanfuhr\BladexComponents\Support\ProjectConfig;
use Ivanfuhr\BladexComponents\Support\ProjectLock;

class InitCommand extends RegistryCommand
{
    protected $signature = 'bladex-components:init
                            {--force : Overwrite an existing project config file}';

    protected $description = 'Create bladex-components.json and an empty lock file for owned UI components.';

    public function handle(
        ProjectConfig $projectConfig,
        ProjectLock $projectLock,
        ProjectScaffolder $scaffolder,
    ): int {
        if ($projectConfig->exists() && ! $this->option('force')) {
            $this->components->error('bladex-components.json already exists. Use --force to overwrite it.');

            return self::FAILURE;
        }

        $projectConfig->write($projectConfig->defaultConfig());

        if (! $projectLock->exists()) {
            $projectLock->writeEmpty();
        }

        $written = $scaffolder->scaffold($projectConfig, $projectLock, (bool) $this->option('force'));

        $this->components->info('Created bladex-components.json.');
        $this->line('UI path: '.$projectConfig->uiPath());
        $this->line('Registry: '.config('bladex-components.default_registry_url'));

        foreach ($written as $path) {
            $this->line('Scaffolded '.$path);
        }

        return self::SUCCESS;
    }
}
