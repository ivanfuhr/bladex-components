<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Empty;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Title extends StdComponent
{
    public function __construct(
        public int $level = 3,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.empty.title';
    }

    protected function resolveViewData(array $data = []): array
    {
        return [
            'resolvedLevel' => max(1, min(6, $this->level)),
        ];
    }
}
