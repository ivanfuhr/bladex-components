<?php

declare(strict_types=1);

namespace Ivanfuhr\BladexComponents\Registry;

use RuntimeException;

final class RegistryResolver
{
    public function __construct(
        private readonly RegistryClient $client,
    ) {}

    /**
     * @param  list<array<string, mixed>>  $indexItems
     * @param  list<string>  $requestedNames
     * @return list<array<string, mixed>>
     */
    public function resolve(string $registryUrl, array $indexItems, array $requestedNames): array
    {
        $indexByName = [];

        foreach ($indexItems as $item) {
            $name = $item['name'] ?? null;

            if (! is_string($name) || $name === '') {
                continue;
            }

            $indexByName[$name] = $item;
        }

        $resolved = [];
        $visiting = [];
        $visited = [];

        foreach ($requestedNames as $name) {
            $this->resolveName($registryUrl, $name, $indexByName, $resolved, $visiting, $visited);
        }

        return $resolved;
    }

    /**
     * @param  array<string, array<string, mixed>>  $indexByName
     * @param  list<array<string, mixed>>  $resolved
     * @param  array<string, bool>  $visiting
     * @param  array<string, bool>  $visited
     */
    private function resolveName(
        string $registryUrl,
        string $name,
        array $indexByName,
        array &$resolved,
        array &$visiting,
        array &$visited,
    ): void {
        if (isset($visited[$name])) {
            return;
        }

        if (isset($visiting[$name])) {
            throw new RuntimeException("Circular registry dependency detected for [{$name}].");
        }

        if (! isset($indexByName[$name])) {
            throw new RuntimeException("Registry item [{$name}] was not found in the index.");
        }

        $visiting[$name] = true;

        $summary = $indexByName[$name];
        $dependencies = $summary['registryDependencies'] ?? [];

        if (is_array($dependencies)) {
            foreach ($dependencies as $dependency) {
                if (! is_string($dependency) || $dependency === '') {
                    continue;
                }

                $this->resolveName($registryUrl, $dependency, $indexByName, $resolved, $visiting, $visited);
            }
        }

        $item = $this->client->fetchItem($registryUrl, $name);

        $resolved[] = $item;

        unset($visiting[$name]);
        $visited[$name] = true;
    }
}
