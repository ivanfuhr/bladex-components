<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\TimePicker;

use Illuminate\Support\Facades\View;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Button extends StencilComponent
{
    protected function stencilView(): string
    {
        return 'stencil::components.time-picker.button';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $placeholder = View::getConsumableComponentData('placeholder', null);
        $invalid = View::getConsumableComponentData('invalid', false);
        $disabled = View::getConsumableComponentData('disabled', false);
        $clearable = View::getConsumableComponentData('clearable', false);
        $size = View::getConsumableComponentData('size', null);

        $triggerAttributes = stencil_apply_interaction(
            $this->attributes
                ->class([
                    'time-picker__trigger',
                    'group flex min-w-0 flex-1 items-center justify-between gap-2 text-left',
                    stencil_field_surface_classes($size, false, 'pointer'),
                    $invalid ? 'border-red-500' : null,
                ])
                ->merge([
                    'type' => 'button',
                    'aria-haspopup' => 'listbox',
                    'aria-expanded' => 'false',
                ]),
            nativeDisabled: true,
        );

        $listboxId = $this->attributes->get('listbox-id') ?? View::getConsumableComponentData('listboxId');

        if (filled($listboxId)) {
            $triggerAttributes = $triggerAttributes->merge(['aria-controls' => $listboxId]);
        }

        if ($disabled) {
            $triggerAttributes = $triggerAttributes->merge(['disabled' => true]);
        }

        return [
            'placeholder' => $placeholder,
            'clearable' => $clearable,
            'triggerAttributes' => $triggerAttributes,
        ];
    }
}
