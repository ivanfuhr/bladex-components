<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Tests;

use Ivanfuhr\Stencil\StencilServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function defineEnvironment($app): void
    {
        $token = getenv('TEST_TOKEN');
        $suffix = ($token !== false && $token !== '') ? $token : (string) getmypid();

        // Always isolate project config so Pest never overwrites the workbench
        // playbook's stencil.json with stub icon paths.
        $app['config']->set(
            'stencil.project_config_file',
            'storage/framework/testing/stencil-'.$suffix.'.json',
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        if ($this->shouldSeedStencilTestIcons()) {
            seedStencilTestIcons();
        }
    }

    protected function shouldSeedStencilTestIcons(): bool
    {
        return array_intersect(['registry-isolated', 'config-isolated'], $this->groups()) === [];
    }

    protected function getPackageProviders($app): array
    {
        return [
            StencilServiceProvider::class,
        ];
    }
}
