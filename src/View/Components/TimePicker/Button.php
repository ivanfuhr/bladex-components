<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\TimePicker;

use Illuminate\Support\Facades\View;
use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Button extends StdComponent
{
    protected function stdView(): string
    {
        return 'std-components::components.time-picker.button';
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

        $triggerAttributes = std_apply_interaction(
            $this->attributes
                ->class([
                    'time-picker__trigger',
                    'group flex min-w-0 flex-1 items-center justify-between gap-2 text-left',
                    std_field_surface_classes($size, false, 'pointer'),
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
