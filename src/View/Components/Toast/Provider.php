<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Toast;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Provider extends StdComponent
{
    public function __construct(
        public mixed $position = 'bottom-right',
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.toast.provider';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $positionClasses = match ($this->position) {
            'top-left' => 'left-4 top-4 items-start',
            'top-center' => 'left-1/2 top-4 -translate-x-1/2 items-center',
            'top-right' => 'right-4 top-4 items-end',
            'bottom-left' => 'bottom-4 left-4 items-start',
            'bottom-center' => 'bottom-4 left-1/2 -translate-x-1/2 items-center',
            default => 'bottom-4 right-4 items-end',
        };

        return [
            'positionClasses' => $positionClasses,
        ];
    }
}
