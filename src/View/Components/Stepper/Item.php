<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Stepper;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Item extends StdComponent
{
    public function __construct(
        public mixed $value = null,
        public mixed $step = null,
        public mixed $completed = null,
        public bool $disabled = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.stepper.item';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $orientation = $this->aware('orientation', 'horizontal');
        $defaultValue = $this->aware('defaultValue');

        $isCurrent = filled($defaultValue) && (string) $this->value === (string) $defaultValue;

        $state = match (true) {
            $isCurrent => 'active',
            $this->completed === true => 'completed',
            default => 'inactive',
        };

        return [
            'isVertical' => $orientation === 'vertical',
            'isDisabled' => $this->disabled,
            'isCurrent' => $isCurrent,
            'state' => $state,
        ];
    }
}
