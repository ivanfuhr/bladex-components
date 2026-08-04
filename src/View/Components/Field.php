<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

use Throwable;

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
     * @return array<string, mixed>
     */
    public function data(): array
    {
        $data = parent::data();

        try {
            $resolved = $this->computedViewData($data);

            return array_merge($data, array_filter([
                'fieldInvalid' => $resolved['resolvedFieldInvalid'] ?? null,
                'controlId' => $resolved['resolvedControlId'] ?? null,
                'name' => $resolved['resolvedName'] ?? null,
                'descriptionId' => $resolved['resolvedDescriptionId'] ?? null,
                'errorId' => $resolved['resolvedErrorId'] ?? null,
                'describedBy' => $resolved['resolvedDescribedBy'] ?? null,
            ], static fn (mixed $value): bool => $value !== null && $value !== ''));
        } catch (Throwable) {
            return $data;
        }
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

        $descriptionId = filled($controlId) ? $controlId.'-description' : null;
        $errorId = filled($name) ? $name.'-errors' : null;
        $describedBy = collect([$descriptionId, $errorId])->filter()->implode(' ');

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
            'resolvedDescriptionId' => $descriptionId,
            'resolvedErrorId' => $errorId,
            'resolvedDescribedBy' => filled($describedBy) ? $describedBy : null,
        ];
    }
}
