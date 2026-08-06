<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class Label extends StdComponent
{
    public function __construct(
        public mixed $for = null,
        public mixed $badge = null,
        public bool $required = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.label.index';
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
            std_label_classes(),
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
