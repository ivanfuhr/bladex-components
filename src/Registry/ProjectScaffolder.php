<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Registry;

use FilesystemIterator;
use Illuminate\Support\Facades\File;
use Ivanfuhr\Stencil\Support\ProjectConfig;
use Ivanfuhr\Stencil\Support\ProjectLock;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;

final class ProjectScaffolder
{
    public const string SCAFFOLD_VERSION = '1';

    public function __construct(
        private readonly ProjectIntegrator $integrator,
    ) {}

    /**
     * @return list<string> app-relative paths written
     */
    public function scaffold(ProjectConfig $config, ProjectLock $lock, bool $force = false): array
    {
        $packageRoot = dirname(__DIR__, 2);
        $stubsRoot = $packageRoot.'/stubs';

        if (! is_dir($stubsRoot)) {
            throw new RuntimeException(
                'Package stubs are missing. Run composer registry:build from the package repository.',
            );
        }

        $written = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($stubsRoot, FilesystemIterator::SKIP_DOTS),
        );

        foreach ($iterator as $file) {
            if (! $file->isFile()) {
                continue;
            }

            $relative = substr($file->getPathname(), strlen($stubsRoot) + 1);
            $relative = str_replace('\\', '/', $relative);

            if (str_starts_with($relative, 'support/Stencil/')) {
                $supportRelative = substr($relative, strlen('support/Stencil/'));
                $appRelative = $config->supportPath().'/'.$supportRelative;
            } elseif (str_starts_with($relative, 'resources/')) {
                $appRelative = $relative;
            } elseif (str_starts_with($relative, 'config/')) {
                $appRelative = $relative;
            } elseif (str_starts_with($relative, 'app/')) {
                $appRelative = $relative;
            } else {
                continue;
            }

            $absolute = $config->basePath($appRelative);

            if (is_file($absolute) && ! $force) {
                continue;
            }

            File::ensureDirectoryExists(dirname($absolute));
            File::copy($file->getPathname(), $absolute);
            $written[] = $appRelative;
        }

        $this->registerStencilUiProvider($config, $force);
        $this->integrator->ensureTailwind($config);
        $this->recordScaffold($lock, $written);

        return $written;
    }

    private function registerStencilUiProvider(ProjectConfig $config, bool $force): void
    {
        $providersPath = $config->basePath('bootstrap/providers.php');

        if (! is_file($providersPath)) {
            return;
        }

        $marker = 'App\\Providers\\StencilUiServiceProvider::class';
        $contents = file_get_contents($providersPath);

        if ($contents === false) {
            return;
        }

        if (str_contains($contents, $marker)) {
            return;
        }

        if (! $force && str_contains($contents, 'StencilUiServiceProvider')) {
            return;
        }

        $needle = "return [\n";
        $insertion = "return [\n    App\\Providers\\StencilUiServiceProvider::class,\n";

        if (str_contains($contents, $needle)) {
            $contents = str_replace($needle, $insertion, $contents, $count);

            if ($count > 0) {
                file_put_contents($providersPath, $contents);
            }
        }
    }

    /**
     * @param  list<string>  $written
     */
    private function recordScaffold(ProjectLock $lock, array $written): void
    {
        $data = $lock->read();
        $data['scaffold'] = [
            'version' => self::SCAFFOLD_VERSION,
            'paths' => array_values(array_unique($written)),
        ];
        $lock->write($data);
    }
}
