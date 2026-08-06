<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Field;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Errors extends StdComponent
{
    public function __construct(
        public mixed $name = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.field.errors';
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
