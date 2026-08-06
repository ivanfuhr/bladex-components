<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Stepper;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Separator extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.stepper.separator';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [
            'isVertical' => $this->aware('orientation', 'horizontal') === 'vertical',
        ];
    }
}
