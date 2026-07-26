<?php

declare(strict_types=1);

namespace Ivanfuhr\BladexComponents\Support;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;
use RuntimeException;

final class ProjectConfig
{
    public function __construct(
        private readonly Application $app,
    ) {}

    public function exists(): bool
    {
        return is_file($this->path());
    }

    public function path(): string
    {
        return $this->app->basePath(config('bladex-components.project_config_file', 'bladex-components.json'));
    }

    public function basePath(string $path = ''): string
    {
        return $this->app->basePath($path);
    }

    /**
     * @return array<string, mixed>
     */
    public function read(): array
    {
        if (! $this->exists()) {
            throw new RuntimeException('Project config not found. Run bladex-components:init first.');
        }

        $contents = file_get_contents($this->path());

        if ($contents === false) {
            throw new RuntimeException('Unable to read project config.');
        }

        $data = json_decode($contents, true);

        if (! is_array($data)) {
            throw new RuntimeException('Project config is not valid JSON.');
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function write(array $data): void
    {
        $encoded = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if ($encoded === false) {
            throw new RuntimeException('Unable to encode project config.');
        }

        $encoded .= "\n";

        if (file_put_contents($this->path(), $encoded) === false) {
            throw new RuntimeException('Unable to write project config.');
        }
    }

    public function uiPath(): string
    {
        $data = $this->read();

        return (string) Arr::get($data, 'paths.ui', config('bladex-components.default_ui_path', 'resources/views/ui'));
    }

    public function resolvedUiPath(): string
    {
        return $this->basePath($this->uiPath());
    }

    public function iconsPath(): string
    {
        $data = $this->tryRead();

        if (is_array($data)) {
            $fromProject = Arr::get($data, 'paths.icons');

            if (is_string($fromProject) && $fromProject !== '') {
                return $fromProject;
            }
        }

        return (string) config('bladex-components.default_icons_path', 'resources/views/ui/icons');
    }

    public function resolvedIconsPath(): string
    {
        return $this->basePath($this->iconsPath());
    }

    public function registryUrl(): string
    {
        $data = $this->read();

        return (string) Arr::get($data, 'registry', config('bladex-components.default_registry_url'));
    }

    /**
     * @return array<string, mixed>
     */
    public function typographyOverride(): array
    {
        $data = $this->tryRead();

        if (! is_array($data)) {
            return [];
        }

        $typography = Arr::get($data, 'typography', []);

        return is_array($typography) ? $typography : [];
    }

    /**
     * @return array<string, mixed>
     */
    public function defaultConfig(): array
    {
        return [
            '$schema' => config('bladex-components.default_schema_url'),
            'registry' => config('bladex-components.default_registry_url'),
            'paths' => [
                'ui' => config('bladex-components.default_ui_path', 'resources/views/ui'),
                'icons' => config('bladex-components.default_icons_path', 'resources/views/ui/icons'),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function tryRead(): ?array
    {
        if (! $this->exists()) {
            return null;
        }

        try {
            return $this->read();
        } catch (RuntimeException) {
            return null;
        }
    }
}
