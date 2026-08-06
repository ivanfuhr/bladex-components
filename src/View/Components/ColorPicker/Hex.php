<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\ColorPicker;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Hex extends StdComponent
{
    public function __construct(
        public mixed $currentValue = '#000000',
        public mixed $popoverId = null,
        public mixed $placeholderText = '#000000',
        public bool $invalid = false,
        public bool $disabled = false,
        public mixed $size = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.color-picker.hex';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $isSmall = $this->size === 'sm';

        $hexClasses = collect([
            'color-picker__hex',
            'min-w-0 flex-1 border-0 bg-transparent shadow-none',
            std_input_control_classes($this->size),
            'font-mono uppercase tracking-wide text-zinc-950 placeholder:text-zinc-500',
            'focus-visible:outline-none focus-visible:ring-0',
            'dark:text-zinc-50 dark:placeholder:text-zinc-400',
            $isSmall ? 'px-2.5' : 'px-3',
            $this->invalid ? 'text-red-950 dark:text-red-50' : null,
        ])->filter()->implode(' ');

        $hexAttributes = std_apply_interaction(
            $this->attributes
                ->class($hexClasses)
                ->merge([
                    'type' => 'text',
                    'data-color-picker-hex' => true,
                    'value' => strtoupper((string) $this->currentValue),
                    'placeholder' => $this->placeholderText,
                    'spellcheck' => 'false',
                    'inputmode' => 'text',
                    'autocomplete' => 'off',
                    'aria-label' => __('Hex color value'),
                    'aria-expanded' => 'false',
                ]),
            nativeDisabled: true,
        );

        if (filled($this->popoverId)) {
            $hexAttributes = $hexAttributes->merge([
                'aria-controls' => $this->popoverId,
            ]);
        }

        if ($this->disabled) {
            $hexAttributes = $hexAttributes->merge(['disabled' => true]);
        }

        if ($this->invalid) {
            $hexAttributes = $hexAttributes->merge(['aria-invalid' => 'true']);
        }

        return [
            'hexAttributes' => $hexAttributes,
        ];
    }
}
