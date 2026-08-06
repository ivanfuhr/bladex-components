<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Field;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Label extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.field.label';
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
