<?php

declare(strict_types=1);

namespace Workbench\App\Playbook;

final readonly class PlaybookControl
{
    /**
     * @param  array<string, string>  $options
     */
    public function __construct(
        public string $key,
        public string $label,
        public string $type,
        public array $options = [],
        public mixed $default = null,
    ) {}

    /**
     * @param  array<string, mixed>  $definition
     */
    public static function fromArray(array $definition): self
    {
        return new self(
            key: (string) $definition['key'],
            label: (string) $definition['label'],
            type: (string) $definition['type'],
            options: (array) ($definition['options'] ?? []),
            default: $definition['default'] ?? null,
        );
    }
}
