<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Tests;

use Ivanfuhr\Stencil\StencilServiceProvider;
use Ivanfuhr\Stencil\Support\ProjectConfig;
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
        if ($this->usesRegistryIsolatedEnvironment()) {
            cleanupOwnedProjectArtifacts(testbenchBasePath());
        }

        parent::setUp();

        if ($this->usesRegistryIsolatedEnvironment()) {
            config(['stencil.project_config_file' => 'stencil.json']);
            $this->app->forgetInstance(ProjectConfig::class);
        }

        if ($this->shouldSeedStencilTestIcons()) {
            seedStencilTestIcons();
        }
    }

    protected function usesRegistryIsolatedEnvironment(): bool
    {
        return in_array('registry-isolated', $this->groups(), true);
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
