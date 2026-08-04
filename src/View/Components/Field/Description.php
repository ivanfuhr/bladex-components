<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Field;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Description extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.field.description';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $descriptionId = $data['descriptionId'] ?? $this->aware('descriptionId');

        return [
            'descriptionId' => $descriptionId,
        ];
    }
}
