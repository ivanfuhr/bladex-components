<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class Heading extends StdComponent
{
    public function __construct(
        public mixed $level = null,
        public mixed $variant = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.heading.index';
    }

    protected function resolveViewData(array $data = []): array
    {
        $level = max(1, min(6, (int) ($this->level ?? std_default_heading_level())));

        return [
            'resolvedLevel' => $level,
            'classes' => std_heading_classes($level, $this->variant),
        ];
    }
}
