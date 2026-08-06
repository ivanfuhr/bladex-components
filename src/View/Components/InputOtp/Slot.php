<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\InputOtp;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Slot extends StdComponent
{
    public function __construct(
        public int $index = 0,
        public bool $invalid = false,
        public bool $disabled = false,
        public mixed $size = null,
        public mixed $value = null,
        public mixed $mode = null,
        public mixed $length = null,
        public mixed $controlId = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.input-otp.slot';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) std_ancestor_attribute('fieldInvalid', false);
        $name = std_ancestor_attribute('name');
        $isInvalid = $this->invalid || $fieldInvalid || std_field_has_errors($name);

        $index = max(0, $this->index);
        $length = max(1, (int) ($this->length ?? std_ancestor_attribute('length', 6)));
        $mode = $this->mode ?? std_ancestor_attribute('mode', 'numeric');
        $mode = in_array($mode, ['numeric', 'alphanumeric'], true) ? $mode : 'numeric';

        $resolvedInputOtpId = $this->controlId ?? std_ancestor_attribute('inputOtpId');
        $resolvedInputOtpId = filled($resolvedInputOtpId)
            ? $resolvedInputOtpId
            : (filled($name) ? $name : null);

        $scalarValue = filled($this->value) ? (string) $this->value : '';
        $char = mb_substr($scalarValue, $index, 1);

        $slotId = filled($resolvedInputOtpId)
            ? $resolvedInputOtpId.($index === 0 ? '' : '-'.$index)
            : null;

        $ariaLabel = __('Digit :position of :length', [
            'position' => $index + 1,
            'length' => $length,
        ]);

        $slotClasses = collect([
            'input-otp__slot',
            'text-center font-medium tabular-nums !px-0',
            $this->size === 'sm' ? 'w-8' : 'w-9',
            std_field_surface_classes($this->size, false, 'text'),
            std_invalid_field_classes(),
            $isInvalid ? 'border-red-500 focus-visible:ring-red-500/20 dark:border-red-500' : null,
        ])->filter()->implode(' ');

        $inputAttributes = std_apply_interaction($this->attributes
            ->except(['index', 'invalid', 'disabled', 'size'])
            ->class($slotClasses)
            ->merge([
                'type' => 'text',
                'inputmode' => $mode === 'numeric' ? 'numeric' : 'text',
                'autocomplete' => $index === 0 ? 'one-time-code' : 'off',
                'autocapitalize' => 'characters',
                'autocorrect' => 'off',
                'spellcheck' => 'false',
                'aria-label' => $ariaLabel,
                'data-input-otp-slot' => true,
                'data-index' => (string) $index,
                'value' => $char,
            ]),
            nativeDisabled: true,
        );

        if ($mode === 'numeric') {
            $inputAttributes = $inputAttributes->merge(['pattern' => '[0-9]*']);
        }

        if ($isInvalid) {
            $inputAttributes = $inputAttributes->merge(['aria-invalid' => 'true']);
        }

        if ($this->disabled) {
            $inputAttributes = $inputAttributes->merge(['disabled' => true]);
        }

        if (filled($slotId)) {
            $inputAttributes = $inputAttributes->merge(['id' => $slotId]);
        }

        return [
            'inputAttributes' => $inputAttributes,
        ];
    }
}
