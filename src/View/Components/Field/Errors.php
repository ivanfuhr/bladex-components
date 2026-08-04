<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Field;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Errors extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.field.errors';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $errorId = $data['errorId'] ?? $this->aware('errorId');
        $name = $this->attributes->get('name') ?? $this->name;

        $wrapperAttributes = $this->attributes
            ->except('name')
            ->class('field__errors')
            ->merge(['data-field-errors' => true]);

        if (filled($errorId)) {
            $wrapperAttributes = $wrapperAttributes->merge(['id' => $errorId]);
        }

        return [
            'name' => $name,
            'wrapperAttributes' => $wrapperAttributes,
        ];
    }
}
