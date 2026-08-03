<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Accordion extends StencilComponent
{
    public function __construct(
        public bool $exclusive = false,
        public mixed $multiple = null,
        public bool $transition = false,
        public mixed $variant = null,
        public bool $bordered = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.accordion.index';
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
