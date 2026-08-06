<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Tooltip;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Content extends StdComponent
{
    public function __construct(
        public mixed $side = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.tooltip.content';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'resolvedSide' => $this->side ?? $this->aware('side', 'top'),
        ];
    }
}
