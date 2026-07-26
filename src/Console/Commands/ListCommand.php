<?php

declare(strict_types=1);

namespace Ivanfuhr\BladexComponents\Console\Commands;

use Ivanfuhr\BladexComponents\Registry\RegistryClient;
use Ivanfuhr\BladexComponents\Support\ProjectConfig;
use Ivanfuhr\BladexComponents\Support\ProjectLock;
use Throwable;

class ListCommand extends RegistryCommand
{
    protected $signature = 'bladex-components:list
                            {--installed : Only show installed items}
                            {--all : Show every registry item including installed state}';

    protected $description = 'List registry UI components.';

    public function handle(
        ProjectConfig $projectConfig,
        ProjectLock $projectLock,
        RegistryClient $registryClient,
    ): int {
        $installedOnly = (bool) $this->option('installed');
        $installed = $projectLock->installedNames();

        if ($installedOnly) {
            if ($installed === []) {
                $this->components->warn('No installed registry items.');

                return self::SUCCESS;
            }

            foreach ($installed as $name) {
                $this->line($name.' [installed]');
            }

            return self::SUCCESS;
        }

        if (! $projectConfig->exists()) {
            $this->components->error('Project config not found. Run bladex-components:init first.');

            return self::FAILURE;
        }

        $registryUrl = $projectConfig->registryUrl();

        try {
            $index = $registryClient->fetchIndex($registryUrl);
        } catch (Throwable $exception) {
            $this->components->error($exception->getMessage());

            return self::FAILURE;
        }

        foreach ($index['items'] as $item) {
            $name = (string) ($item['name'] ?? '');
            $title = (string) ($item['title'] ?? $name);
            $suffix = in_array($name, $installed, true) ? ' [installed]' : '';

            $this->line("{$title} ({$name}){$suffix}");
        }

        return self::SUCCESS;
    }
}
