<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class ButtonGroup extends StencilComponent
{
    public function __construct(
        public string $orientation = 'horizontal',
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.button-group.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $orientation = $this->orientation === 'vertical' ? 'vertical' : 'horizontal';

        $mergedAttributes = $this->attributes
            ->class([
                'button-group',
                'flex w-fit items-stretch',
                'has-[>[data-button-group]]:gap-2',
                '[&>*]:focus-visible:relative [&>*]:focus-visible:z-10',
                '[&_input]:flex-1',
                $orientation === 'vertical' ? 'flex-col' : 'flex-row',
                $orientation === 'horizontal'
                    ? '[&>*:not(:first-child)]:rounded-l-none [&>*:not(:first-child)]:border-l-0 [&>*:not(:last-child)]:rounded-r-none'
                    : '[&>*:not(:first-child)]:rounded-t-none [&>*:not(:first-child)]:border-t-0 [&>*:not(:last-child)]:rounded-b-none',
            ])
            ->merge([
                'role' => 'group',
                'data-button-group' => true,
                'data-orientation' => $orientation,
            ]);

        return [
            'mergedAttributes' => $mergedAttributes,
        ];
    }
}
