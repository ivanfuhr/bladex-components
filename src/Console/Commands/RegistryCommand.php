<?php

declare(strict_types=1);

namespace Ivanfuhr\BladexComponents\Console\Commands;

use Illuminate\Console\Command;
use Ivanfuhr\BladexComponents\Support\ProjectConfig;
use Ivanfuhr\BladexComponents\Support\ProjectLock;

abstract class RegistryCommand extends Command
{
    protected function projectConfig(): ProjectConfig
    {
        return new ProjectConfig($this->laravel);
    }

    protected function projectLock(): ProjectLock
    {
        return new ProjectLock($this->laravel);
    }
}
