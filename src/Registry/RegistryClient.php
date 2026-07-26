<?php

declare(strict_types=1);

namespace Ivanfuhr\BladexComponents\Registry;

use Illuminate\Support\Facades\Http;
use RuntimeException;

final class RegistryClient
{
    public function __construct(
        private readonly string $packageRegistryPath,
    ) {}

    /**
     * @return array{name: string, homepage?: string|null, items: list<array<string, mixed>>}
     */
    public function fetchIndex(string $registryUrl): array
    {
        if ($this->isPackageRegistry($registryUrl)) {
            return $this->fetchIndexFromPackage();
        }

        return $this->fetchIndexFromRemote($registryUrl);
    }

    /**
     * @param  array{name: string, homepage?: string|null, items: list<array<string, mixed>>}  $index
     * @return array{name: string, homepage?: string|null, items: list<array<string, mixed>>}
     */
    private function mergeMissingPackageItems(array $index): array
    {
        if (! is_dir($this->packageRegistryPath)) {
            return $index;
        }

        try {
            $packageIndex = $this->fetchIndexFromPackage();
        } catch (RuntimeException) {
            return $index;
        }

        $known = [];

        foreach ($index['items'] as $item) {
            $name = $item['name'] ?? null;

            if (is_string($name) && $name !== '') {
                $known[$name] = true;
            }
        }

        foreach ($packageIndex['items'] as $item) {
            $name = $item['name'] ?? null;

            if (! is_string($name) || $name === '' || isset($known[$name])) {
                continue;
            }

            $index['items'][] = $item;
            $known[$name] = true;
        }

        return $index;
    }

    /**
     * @return array{name: string, homepage?: string|null, items: list<array<string, mixed>>}
     */
    private function fetchIndexFromRemote(string $registryUrl): array
    {
        $response = Http::timeout(30)->get($registryUrl);

        if ($response->failed()) {
            if ($response->status() === 404 && is_dir($this->packageRegistryPath)) {
                return $this->fetchIndexFromPackage();
            }

            throw new RuntimeException("Unable to fetch registry index [{$registryUrl}]: {$response->status()}");
        }

        /** @var array<string, mixed> $data */
        $data = $response->json();

        if (! isset($data['items']) || ! is_array($data['items'])) {
            throw new RuntimeException('Registry index is missing an items array.');
        }

        $index = [
            'name' => (string) ($data['name'] ?? 'registry'),
            'homepage' => isset($data['homepage']) ? (string) $data['homepage'] : null,
            'items' => array_values($data['items']),
        ];

        return $this->mergeMissingPackageItems($index);
    }

    /**
     * @return array<string, mixed>
     */
    public function fetchItem(string $registryUrl, string $name): array
    {
        if ($this->isPackageRegistry($registryUrl)) {
            return $this->fetchItemFromPackage($name);
        }

        $itemUrl = $this->itemUrlFor($registryUrl, $name);

        $response = Http::timeout(30)->get($itemUrl);

        if ($response->failed()) {
            if ($response->status() === 404 && is_dir($this->packageRegistryPath)) {
                return $this->fetchItemFromPackage($name);
            }

            throw new RuntimeException("Unable to fetch registry item [{$name}] from [{$itemUrl}]: {$response->status()}");
        }

        /** @var array<string, mixed> $data */
        $data = $response->json();

        if (($data['name'] ?? null) !== $name) {
            $data['name'] = $name;
        }

        return $data;
    }

    public function itemUrlFor(string $registryUrl, string $name): string
    {
        if ($this->isPackageRegistry($registryUrl)) {
            return $this->packageRegistryPath.'/items/'.$name.'.json';
        }

        $base = preg_replace('#/registry\.json$#', '', $registryUrl) ?? $registryUrl;

        return rtrim($base, '/').'/items/'.$name.'.json';
    }

    private function isPackageRegistry(string $registryUrl): bool
    {
        return $registryUrl === 'package'
            || str_starts_with($registryUrl, 'package://');
    }

    /**
     * @return array{name: string, homepage?: string|null, items: list<array<string, mixed>>}
     */
    private function fetchIndexFromPackage(): array
    {
        $data = $this->readPackageJson('registry.json');

        if (! isset($data['items']) || ! is_array($data['items'])) {
            throw new RuntimeException('Package registry index is missing an items array.');
        }

        return [
            'name' => (string) ($data['name'] ?? 'registry'),
            'homepage' => isset($data['homepage']) ? (string) $data['homepage'] : null,
            'items' => array_values($data['items']),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function fetchItemFromPackage(string $name): array
    {
        $data = $this->readPackageJson('items/'.$name.'.json');

        if (($data['name'] ?? null) !== $name) {
            $data['name'] = $name;
        }

        return $data;
    }

    /**
     * @return array<string, mixed>
     */
    private function readPackageJson(string $relativePath): array
    {
        $path = $this->packageRegistryPath.'/'.ltrim($relativePath, '/');

        if (! is_file($path)) {
            throw new RuntimeException("Package registry file not found [{$path}].");
        }

        $contents = file_get_contents($path);

        if ($contents === false) {
            throw new RuntimeException("Unable to read package registry file [{$path}].");
        }

        $data = json_decode($contents, true);

        if (! is_array($data)) {
            throw new RuntimeException("Package registry file is not valid JSON [{$path}].");
        }

        return $data;
    }
}
