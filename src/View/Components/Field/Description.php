<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Field;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Description extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.field.description';
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
