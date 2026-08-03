<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

use Illuminate\Support\Str;

final class SwitchControl extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $value = '1',
        public bool $checked = false,
        public bool $invalid = false,
        public mixed $size = null,
        public mixed $controlId = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.switch.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $isInvalid = $this->invalid || $fieldInvalid;

        $controlId = $this->attributes->get('id')
            ?? $this->controlId
            ?? (filled($this->name) ? $this->name : 'switch-'.Str::uuid()->toString());

        $rootClasses = stencil_switch_root_classes($this->size);
        $trackClasses = stencil_switch_track_classes($this->size);
        $thumbClasses = stencil_switch_thumb_classes($this->size);

        $wrapperClass = $this->attributes->get('class');

        $controlAttributes = stencil_apply_interaction($this->attributes
            ->except(['id', 'class'])
            ->class([
                'switch__input',
                'sr-only',
            ])
            ->merge([
                'type' => 'checkbox',
                'role' => 'switch',
                'id' => $controlId,
                'data-switch-control' => true,
            ]),
            nativeDisabled: true,
        );

        if (filled($this->name)) {
            $controlAttributes = $controlAttributes->merge(['name' => $this->name]);
        }

        if (filled($this->value)) {
            $controlAttributes = $controlAttributes->merge(['value' => $this->value]);
        }

        if ($this->checked) {
            $controlAttributes = $controlAttributes->merge(['checked' => true]);
        }

        if ($isInvalid) {
            $controlAttributes = $controlAttributes->merge(['aria-invalid' => 'true']);
        }

        return [
            'rootClasses' => $rootClasses,
            'trackClasses' => $trackClasses,
            'thumbClasses' => $thumbClasses,
            'wrapperClass' => $wrapperClass,
            'controlAttributes' => $controlAttributes,
        ];
    }
}
