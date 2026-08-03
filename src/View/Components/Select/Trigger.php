<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Select;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Trigger extends StencilComponent
{
    public function __construct(
        public mixed $controlId = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.select.trigger';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $size = $this->attributes->get('size') ?? stencil_ancestor_attribute('size');
        $invalid = (bool) ($this->attributes->get('invalid') ?? stencil_ancestor_attribute('invalid', false));
        $disabled = (bool) ($this->attributes->get('disabled') ?? stencil_ancestor_attribute('disabled', false));
        $selectId = $this->attributes->get('select-id') ?? stencil_ancestor_attribute('selectId');
        $listboxId = $this->attributes->get('listbox-id') ?? stencil_ancestor_attribute('listboxId');
        $multiple = (bool) ($this->attributes->get('multiple') ?? stencil_ancestor_attribute('multiple', false));
        $display = $this->attributes->get('display') ?? stencil_ancestor_attribute('display', 'count');
        $controlId = $this->controlId ?? stencil_ancestor_attribute('controlId');

        $chipsLayout = $multiple && $display === 'chips';

        $triggerAttributes = stencil_apply_interaction($this->attributes
            ->except(['size', 'invalid', 'disabled', 'select-id', 'listbox-id', 'multiple', 'display'])
            ->class([
                'select__trigger',
                'group flex w-full min-w-0 items-center justify-between gap-2 text-left',
                $chipsLayout ? 'h-auto min-h-9 py-1.5' : null,
                stencil_field_surface_classes($size, false, 'pointer'),
                stencil_invalid_field_classes(),
                'aria-expanded:border-zinc-300 aria-expanded:ring-2 aria-expanded:ring-zinc-950/10',
                'dark:aria-expanded:border-zinc-600 dark:aria-expanded:ring-zinc-300/20',
                $invalid ? 'border-red-500 focus-visible:ring-red-500/20 dark:border-red-500' : null,
            ])
            ->merge([
                'type' => 'button',
                'aria-haspopup' => 'listbox',
                'aria-expanded' => 'false',
            ]),
            nativeDisabled: true,
        );

        if ($invalid) {
            $triggerAttributes = $triggerAttributes->merge(['aria-invalid' => 'true']);
        }

        if ($disabled) {
            $triggerAttributes = $triggerAttributes->merge(['disabled' => true]);
        }

        $triggerId = filled($controlId) ? $controlId : (filled($selectId) ? $selectId : null);

        if (filled($triggerId)) {
            $triggerAttributes = $triggerAttributes->merge(['id' => $triggerId]);
        }

        if (filled($listboxId)) {
            $triggerAttributes = $triggerAttributes->merge(['aria-controls' => $listboxId]);
        }

        $chevronClasses = $size === 'sm' ? 'size-3.5 shrink-0 opacity-50' : 'size-4 shrink-0 opacity-50';

        return [
            'chipsLayout' => $chipsLayout,
            'triggerAttributes' => $triggerAttributes,
            'chevronClasses' => $chevronClasses,
        ];
    }
}
