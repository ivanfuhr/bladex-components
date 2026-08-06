<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class Accordion extends StdComponent
{
    public function __construct(
        public bool $exclusive = false,
        public mixed $multiple = null,
        public bool $transition = false,
        public mixed $variant = null,
        public bool $bordered = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.accordion.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $isExclusive = $this->multiple === null
            ? $this->exclusive
            : ! (bool) $this->multiple;

        return [
            'isExclusive' => $isExclusive,
        ];
    }
}
