<?php

declare(strict_types=1);

$root = dirname(__DIR__);

require $root.'/vendor/autoload.php';

use Ivanfuhr\Stencil\Registry\OwnedArtifactCompiler;
use Ivanfuhr\Stencil\Registry\SupportStubGenerator;

$generator = new SupportStubGenerator(new OwnedArtifactCompiler);
$generator->generate($root, $root.'/stubs');

fwrite(STDOUT, "Stubs generated under stubs/\n");
