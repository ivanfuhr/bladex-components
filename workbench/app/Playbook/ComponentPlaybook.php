<?php

declare(strict_types=1);

namespace Workbench\App\Playbook;

final readonly class ComponentPlaybook
{
    /**
     * @param  list<PlaybookControl>  $controls
     * @param  array<string, mixed>  $defaultState
     */
    public function __construct(
        public string $slug,
        public string $title,
        public string $description,
        public array $controls,
        public array $defaultState,
        public string $previewView,
    ) {}

    /**
     * @return list<string>
     */
    public function controlKeys(): array
    {
        return array_map(static fn (PlaybookControl $control): string => $control->key, $this->controls);
    }
}
