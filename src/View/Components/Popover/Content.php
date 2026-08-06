<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Popover;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Content extends StdComponent
{
    public function __construct(
        public bool $open = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.popover.content';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'align' => $this->aware('align', 'start'),
            'side' => $this->aware('side', 'bottom'),
        ];
    }
}
