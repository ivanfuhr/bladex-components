<?php

declare(strict_types=1);

$root = dirname(__DIR__);

require $root.'/vendor/autoload.php';

use Ivanfuhr\Stencil\Registry\OwnedArtifactCompiler;
use Ivanfuhr\Stencil\Registry\SupportStubGenerator;

$generator = new SupportStubGenerator(new OwnedArtifactCompiler);
$generator->generate($root, $root.'/stubs');

$pint = $root.'/vendor/bin/pint';

if (is_file($pint)) {
    $command = escapeshellarg(PHP_BINARY).' '.escapeshellarg($pint).' '.escapeshellarg($root.'/stubs/support');
    passthru($command, $pintExitCode);

    if ($pintExitCode !== 0) {
        fwrite(STDERR, "Pint failed while formatting generated stubs (exit {$pintExitCode}).\n");
        exit($pintExitCode);
    }
}

fwrite(STDOUT, "Stubs generated under stubs/\n");
