<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Field;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Label extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.field.label';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $resolvedFor = $this->attributes->get('for')
            ?? $this->aware('controlId')
            ?? $this->aware('name');

        return [
            'resolvedFor' => $resolvedFor,
        ];
    }
}
