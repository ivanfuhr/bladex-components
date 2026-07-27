<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Console\Commands;

use Illuminate\Console\Command;
use Ivanfuhr\Stencil\Support\ProjectConfig;
use Ivanfuhr\Stencil\Support\ProjectLock;

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
