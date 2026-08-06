<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\Tests;

use Ivanfuhr\StdComponents\StdComponentsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            StdComponentsServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set(
            'view.compiled',
            sys_get_temp_dir().'/std-components-views-'.getmypid(),
        );
    }
}
