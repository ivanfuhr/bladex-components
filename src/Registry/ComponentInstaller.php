<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Registry;

use Illuminate\Support\Facades\File;
use Ivanfuhr\Stencil\Support\ProjectConfig;
use Ivanfuhr\Stencil\Support\ProjectLock;
use RuntimeException;

final class ComponentInstaller
{
    /**
     * @param  array<string, mixed>  $item
     * @return list<string> app-relative paths written or touched
     */
    public function install(
        ProjectConfig $config,
        ProjectLock $lock,
        array $item,
        string $registryUrl,
        bool $overwrite = false,
        bool $dryRun = false,
    ): array {
        $files = $item['files'] ?? [];

        if (! is_array($files)) {
            throw new RuntimeException('Registry item is missing a files array.');
        }

        $written = [];
        $lockData = $lock->read();
        $itemPaths = [];

        foreach ($files as $file) {
            if (! is_array($file)) {
                continue;
            }

            $locations = $this->resolveFileLocations($config, $file);
            $absoluteTarget = $locations['absolute'];
            $appRelativePath = $locations['appRelative'];
            $content = $file['content'] ?? null;

            if (! is_string($content)) {
                throw new RuntimeException("Registry file [{$appRelativePath}] is missing content.");
            }

            $hash = hash('sha256', $content);

            if (is_file($absoluteTarget) && ! $overwrite) {
                $existing = file_get_contents($absoluteTarget);

                if ($existing !== false && hash('sha256', $existing) !== $hash) {
                    throw new RuntimeException("File already exists and differs: {$appRelativePath}. Use --overwrite to replace it.");
                }

                if ($existing !== false && hash('sha256', $existing) === $hash) {
                    $lockData['files'][$appRelativePath] = $hash;
                    $itemPaths[] = $appRelativePath;

                    continue;
                }
            }

            if (! $dryRun) {
                File::ensureDirectoryExists(dirname($absoluteTarget));
                File::put($absoluteTarget, $content);
            }

            $lockData['files'][$appRelativePath] = $hash;
            $itemPaths[] = $appRelativePath;
            $written[] = $appRelativePath;
        }

        $itemName = (string) ($item['name'] ?? '');

        if ($itemName === '') {
            throw new RuntimeException('Registry item is missing a name.');
        }

        $itemRecord = [
            'name' => $itemName,
            'registry' => $registryUrl,
            'itemHash' => $this->itemHash($item),
            'paths' => array_values(array_unique($itemPaths)),
        ];

        $lockData['items'] = array_values(array_filter(
            $lockData['items'],
            static fn (array $existing): bool => ($existing['name'] ?? '') !== $itemName,
        ));

        $lockData['items'][] = $itemRecord;

        if (! $dryRun) {
            $lock->write($lockData);
        }

        return $written;
    }

    /**
     * @return array{updated: list<string>, skipped: list<string>, modified_locally: list<string>}
     */
    public function update(
        ProjectConfig $config,
        ProjectLock $lock,
        RegistryClient $client,
        ?string $onlyName = null,
        bool $overwrite = false,
    ): array {
        $registryUrl = $config->registryUrl();
        $lockData = $lock->read();
        $result = [
            'updated' => [],
            'skipped' => [],
            'modified_locally' => [],
        ];

        foreach ($lockData['items'] as $installed) {
            $name = $installed['name'] ?? null;

            if (! is_string($name) || $name === '') {
                continue;
            }

            if ($onlyName !== null && $name !== $onlyName) {
                continue;
            }

            $item = $client->fetchItem($registryUrl, $name);
            $files = $item['files'] ?? [];

            if (! is_array($files)) {
                continue;
            }

            foreach ($files as $file) {
                if (! is_array($file)) {
                    continue;
                }

                $locations = $this->resolveFileLocations($config, $file);
                $absoluteTarget = $locations['absolute'];
                $appRelativePath = $locations['appRelative'];
                $content = $file['content'] ?? null;

                if (! is_string($content)) {
                    continue;
                }

                $newHash = hash('sha256', $content);
                $lockHash = $lockData['files'][$appRelativePath] ?? null;

                if (! is_file($absoluteTarget)) {
                    File::ensureDirectoryExists(dirname($absoluteTarget));
                    File::put($absoluteTarget, $content);
                    $lockData['files'][$appRelativePath] = $newHash;
                    $result['updated'][] = $appRelativePath;

                    continue;
                }

                $existing = file_get_contents($absoluteTarget);

                if ($existing === false) {
                    continue;
                }

                $diskHash = hash('sha256', $existing);

                if ($diskHash === $newHash) {
                    $lockData['files'][$appRelativePath] = $newHash;
                    $result['skipped'][] = $appRelativePath;

                    continue;
                }

                if ($lockHash !== null && $diskHash !== $lockHash && ! $overwrite) {
                    $result['modified_locally'][] = $appRelativePath;

                    continue;
                }

                File::put($absoluteTarget, $content);
                $lockData['files'][$appRelativePath] = $newHash;
                $result['updated'][] = $appRelativePath;
            }

            $installed['itemHash'] = $this->itemHash($item);
            $installed['registry'] = $registryUrl;
            $installed['paths'] = $this->pathsFromItem($item, $config);

            $lockData['items'] = array_map(
                static function (array $entry) use ($installed, $name): array {
                    if (($entry['name'] ?? '') === $name) {
                        return $installed;
                    }

                    return $entry;
                },
                $lockData['items'],
            );
        }

        $lock->write($lockData);

        return $result;
    }

    /**
     * @return list<string> app-relative paths removed from lock
     */
    public function remove(
        ProjectConfig $config,
        ProjectLock $lock,
        string $name,
        bool $keepFiles = false,
    ): array {
        if ($lock->findItem($name) === null) {
            throw new RuntimeException("Installed item [{$name}] was not found in the lock file.");
        }

        $itemRecord = $lock->findItem($name);
        $pathsForItem = array_values(array_filter(
            $itemRecord['paths'] ?? [],
            static fn (mixed $path): bool => is_string($path) && $path !== '',
        ));
        $removed = [];

        foreach ($pathsForItem as $path) {
            if (! $keepFiles) {
                $absolute = $config->basePath($path);

                if (is_file($absolute)) {
                    File::delete($absolute);
                }
            }

            $removed[] = $path;
        }

        $lockData = $lock->read();

        foreach ($removed as $path) {
            unset($lockData['files'][$path]);
        }

        $lockData['items'] = array_values(array_filter(
            $lockData['items'],
            static fn (array $entry): bool => ($entry['name'] ?? '') !== $name,
        ));

        $lock->write($lockData);

        return $removed;
    }

    /**
     * @param  array<string, mixed>  $item
     * @return list<string>
     */
    private function pathsFromItem(array $item, ProjectConfig $config): array
    {
        $files = $item['files'] ?? [];

        if (! is_array($files)) {
            return [];
        }

        $paths = [];

        foreach ($files as $file) {
            if (! is_array($file)) {
                continue;
            }

            $paths[] = $this->resolveFileLocations($config, $file)['appRelative'];
        }

        return array_values(array_unique($paths));
    }

    /**
     * @param  array<string, mixed>  $file
     * @return array{absolute: string, appRelative: string}
     */
    private function resolveFileLocations(ProjectConfig $config, array $file): array
    {
        $relativeTarget = $this->targetPath($file);
        $type = (string) ($file['type'] ?? 'registry:ui');
        $baseRelative = match ($type) {
            'registry:asset' => $config->assetsPath(),
            'registry:app' => '',
            default => $config->uiPath(),
        };

        if ($type === 'registry:app') {
            return [
                'absolute' => $config->basePath($relativeTarget),
                'appRelative' => $relativeTarget,
            ];
        }

        return [
            'absolute' => $config->basePath($baseRelative.'/'.$relativeTarget),
            'appRelative' => $baseRelative.'/'.$relativeTarget,
        ];
    }

    /**
     * @param  array<string, mixed>  $file
     */
    private function targetPath(array $file): string
    {
        $target = $file['target'] ?? $file['path'] ?? null;

        if (! is_string($target) || $target === '') {
            throw new RuntimeException('Registry file entry is missing path or target.');
        }

        return ltrim($target, '/');
    }

    /**
     * @param  array<string, mixed>  $item
     */
    private function itemHash(array $item): string
    {
        $encoded = json_encode($item['files'] ?? []);

        return hash('sha256', (string) $encoded);
    }
}
