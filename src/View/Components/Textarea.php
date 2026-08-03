<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

use Illuminate\View\ComponentAttributeBag;

final class Textarea extends StencilComponent
{
    public function __construct(
        public bool $invalid = false,
        public mixed $size = null,
        public bool $autosize = false,
        public bool $counter = false,
        public mixed $controlId = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.textarea.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $isInvalid = $this->invalid || $fieldInvalid || stencil_field_has_errors($this->attributes->get('name'));

        $resolvedControlId = $this->attributes->get('id')
            ?? $this->controlId
            ?? $this->attributes->get('name');

        $userClass = $this->attributes->get('class');
        $applyFullWidth = ! filled($userClass);

        $controlClasses = collect([
            'textarea__control',
            'block min-w-0',
            stencil_textarea_surface_classes($this->size),
            'placeholder:text-zinc-500 dark:placeholder:text-zinc-400',
            stencil_invalid_field_classes(),
            $isInvalid ? 'border-red-500 focus-visible:ring-red-500/20 dark:border-red-500' : null,
            $this->autosize ? 'resize-none overflow-hidden' : null,
        ])->filter()->implode(' ');

        $wrapperClasses = collect([
            'textarea',
            $applyFullWidth ? 'w-full' : null,
            $userClass,
        ])->filter()->implode(' ');

        $wrapperAttributes = (new ComponentAttributeBag([
            'data-textarea' => true,
        ]))->class($wrapperClasses);

        if ($this->autosize) {
            $wrapperAttributes = $wrapperAttributes->merge(['data-textarea-autosize' => true]);
        }

        if ($this->counter) {
            $wrapperAttributes = $wrapperAttributes->merge(['data-textarea-counter' => true]);
        }

        $controlExtraClass = $this->attributes->get('class:textarea') ?? $this->attributes->get('textarea:class');

        $controlAttributes = stencil_apply_interaction($this->attributes
            ->except(['class', 'class:textarea', 'textarea:class', 'autosize', 'counter', 'id'])
            ->class([$controlClasses, $controlExtraClass])
            ->merge([
                'data-textarea-control' => true,
            ]),
        );

        if (filled($resolvedControlId)) {
            $controlAttributes = $controlAttributes->merge(['id' => $resolvedControlId]);
        }

        if ($isInvalid) {
            $controlAttributes = $controlAttributes->merge(['aria-invalid' => 'true']);
        }

        return [
            'wrapperAttributes' => $wrapperAttributes,
            'controlAttributes' => $controlAttributes,
        ];
    }
}
