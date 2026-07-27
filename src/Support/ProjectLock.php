<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Support;

use Illuminate\Contracts\Foundation\Application;
use RuntimeException;

final class ProjectLock
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
        return $this->app->basePath(config('stencil.project_lock_file', 'stencil.lock'));
    }

    /**
     * @return array{items: list<array<string, mixed>>, files: array<string, string>}
     */
    public function read(): array
    {
        if (! $this->exists()) {
            return [
                'items' => [],
                'files' => [],
            ];
        }

        $contents = file_get_contents($this->path());

        if ($contents === false) {
            throw new RuntimeException('Unable to read project lock file.');
        }

        $data = json_decode($contents, true);

        if (! is_array($data)) {
            throw new RuntimeException('Project lock file is not valid JSON.');
        }

        return [
            'items' => array_values($data['items'] ?? []),
            'files' => array_filter($data['files'] ?? [], static fn (mixed $hash): bool => is_string($hash)),
        ];
    }

    /**
     * @param  array{items: list<array<string, mixed>>, files: array<string, string>, scaffold?: array<string, mixed>}  $data
     */
    public function write(array $data): void
    {
        $payload = [
            'items' => $data['items'],
            'files' => $data['files'],
        ];

        if (array_key_exists('scaffold', $data)) {
            $payload['scaffold'] = $data['scaffold'];
        }

        $encoded = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if ($encoded === false) {
            throw new RuntimeException('Unable to encode project lock file.');
        }

        $encoded .= "\n";

        if (file_put_contents($this->path(), $encoded) === false) {
            throw new RuntimeException('Unable to write project lock file.');
        }
    }

    public function writeEmpty(): void
    {
        $this->write([
            'items' => [],
            'files' => [],
        ]);
    }

    /**
     * @return list<string>
     */
    public function installedNames(): array
    {
        $data = $this->read();

        return array_values(array_filter(array_map(
            static fn (array $item): ?string => isset($item['name']) ? (string) $item['name'] : null,
            $data['items'],
        )));
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findItem(string $name): ?array
    {
        $data = $this->read();

        foreach ($data['items'] as $item) {
            if (($item['name'] ?? null) === $name) {
                return $item;
            }
        }

        return null;
    }
}
