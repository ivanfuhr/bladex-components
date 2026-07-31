<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Tests;

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
        parent::defineEnvironment($app);

        $app['config']->set('app.key', 'base64:'.base64_encode(str_repeat('a', 32)));
        $app['config']->set('stencil.validate_tailwind_integration', true);
    }

    protected function defineRoutes($router): void
    {
        $router->middleware('web')
            ->group(dirname(__DIR__).'/workbench/routes/web.php');
    }
}
