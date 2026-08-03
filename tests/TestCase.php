<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Tests;

use Ivanfuhr\Stencil\StencilServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            StencilServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set(
            'view.compiled',
            sys_get_temp_dir().'/stencil-views-'.getmypid(),
        );
    }
}
