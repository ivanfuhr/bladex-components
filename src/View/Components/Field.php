<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

final class Field extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $controlId = null,
        public bool $invalid = false,
        public mixed $orientation = 'block',
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.field.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $name = $this->attributes->get('name') ?? $this->name;
        $controlId = $this->attributes->get('controlId')
            ?? $this->attributes->get('control-id')
            ?? $this->controlId;

        if (! filled($controlId) && filled($name)) {
            $controlId = $name;
        }

        $resolvedFieldInvalid = $this->invalid || stencil_field_has_errors($name);
        $isInline = $this->orientation === 'inline';

        $rootClasses = collect([
            'field',
            'flex min-w-0',
            $isInline ? 'flex-row items-center gap-3' : 'flex-col gap-1.5',
        ])->implode(' ');

        return [
            'resolvedFieldInvalid' => $resolvedFieldInvalid,
            'resolvedControlId' => $controlId,
            'resolvedName' => $name,
            'resolvedIsInline' => $isInline,
            'resolvedRootClasses' => $rootClasses,
        ];
    }
}
