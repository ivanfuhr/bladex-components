<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

use Illuminate\Support\Str;

final class Stepper extends StencilComponent
{
    public function __construct(
        public mixed $defaultValue = null,
        public mixed $orientation = 'horizontal',
        public bool $linear = true,
        public mixed $stepperId = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.stepper.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $stepperId = filled($this->stepperId)
            ? $this->stepperId
            : 'stepper-'.Str::uuid()->toString();

        $isVertical = $this->orientation === 'vertical';

        return [
            'stepperId' => $stepperId,
            'isVertical' => $isVertical,
        ];
    }
}
