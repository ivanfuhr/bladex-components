<?php

declare(strict_types=1);

namespace Ivanfuhr\BladexComponents\Tests;

use Workbench\App\Providers\WorkbenchServiceProvider;

abstract class WorkbenchTestCase extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ...parent::getPackageProviders($app),
            WorkbenchServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('bladex-components.validate_tailwind_integration', true);
    }

    protected function defineRoutes($router): void
    {
        $router->middleware('web')
            ->group(dirname(__DIR__).'/workbench/routes/web.php');
    }
}
