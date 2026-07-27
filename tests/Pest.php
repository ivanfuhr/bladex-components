<?php

declare(strict_types=1);

use Ivanfuhr\Stencil\Tests\TestCase;
use Ivanfuhr\Stencil\Tests\WorkbenchTestCase;

require_once __DIR__.'/Helpers/registry.php';

uses(TestCase::class)->in('Feature');
uses(TestCase::class)->in('Unit');
uses(WorkbenchTestCase::class)->in('Workbench');
