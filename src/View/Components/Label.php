<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Label extends StencilComponent
{
    public function __construct(
        public mixed $for = null,
        public mixed $badge = null,
        public bool $required = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.label.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $classes = collect([
            'label',
            'inline-flex items-center gap-2',
            stencil_label_classes(),
        ])->implode(' ');

        $labelAttributes = $this->attributes
            ->class($classes)
            ->merge([
                'data-label' => true,
            ]);

        if (filled($this->for)) {
            $labelAttributes = $labelAttributes->merge(['for' => $this->for]);
        }

        return [
            'labelAttributes' => $labelAttributes,
        ];
    }
}
