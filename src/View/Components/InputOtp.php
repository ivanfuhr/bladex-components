<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

use Illuminate\Support\Str;

final class InputOtp extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $value = null,
        public int $length = 6,
        public mixed $mode = 'numeric',
        public bool $invalid = false,
        public bool $disabled = false,
        public mixed $size = null,
        public mixed $separated = null,
        public mixed $inputOtpId = null,
        public bool $shortcut = true,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.input-otp.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $invalid = $this->invalid || $fieldInvalid || stencil_field_has_errors($this->name);

        $length = max(1, $this->length);
        $mode = in_array($this->mode, ['numeric', 'alphanumeric'], true) ? $this->mode : 'numeric';

        $inputOtpId = filled($this->inputOtpId)
            ? $this->inputOtpId
            : (filled($this->name) ? $this->name : 'input-otp-'.Str::uuid()->toString());
        $controlId = $inputOtpId;

        $scalarValue = filled($this->value) ? (string) $this->value : '';
        $scalarValue = mb_substr($scalarValue, 0, $length);

        $useSeparator = $this->separated === null
            ? ($length >= 4 && $length % 2 === 0)
            : (bool) $this->separated;

        $half = (int) floor($length / 2);

        $rootAttributes = $this->attributes
            ->except(['shortcut', 'separated', 'mode', 'length', 'value', 'name'])
            ->class([
                'input-otp flex min-w-0 items-center gap-2',
                'w-full' => ! filled($this->attributes->get('class')),
            ])
            ->merge([
                'data-input-otp' => true,
                'data-input-otp-id' => $inputOtpId,
                'data-input-otp-length' => (string) $length,
                'data-input-otp-mode' => $mode,
                'role' => 'group',
                'aria-label' => __('One-time code'),
            ]);

        if ($this->disabled) {
            $rootAttributes = $rootAttributes->merge(['data-disabled' => 'true']);
        }

        if ($invalid) {
            $rootAttributes = $rootAttributes->merge(['data-invalid' => 'true']);
        }

        if (mb_strlen($scalarValue) === $length) {
            $rootAttributes = $rootAttributes->merge(['data-complete' => 'true']);
        }

        return [
            'invalid' => $invalid,
            'length' => $length,
            'mode' => $mode,
            'controlId' => $controlId,
            'scalarValue' => $scalarValue,
            'useSeparator' => $useSeparator,
            'half' => $half,
            'rootAttributes' => $rootAttributes,
        ];
    }
}
