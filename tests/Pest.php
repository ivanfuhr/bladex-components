<?php

declare(strict_types=1);

use Ivanfuhr\BladexComponents\Tests\TestCase;
use Ivanfuhr\BladexComponents\Tests\WorkbenchTestCase;

require_once __DIR__.'/Helpers/registry.php';

uses(TestCase::class)->in('Feature');
uses(TestCase::class)->in('Unit');
uses(WorkbenchTestCase::class)->in('Workbench');
