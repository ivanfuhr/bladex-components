<?php

declare(strict_types=1);

namespace Ivanfuhr\BladexComponents\Tests;

use Ivanfuhr\BladexComponents\BladexComponentsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            BladexComponentsServiceProvider::class,
        ];
    }
}
