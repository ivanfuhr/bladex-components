<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Input;

use Illuminate\Support\Number;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Currency extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $value = null,
        public mixed $currency = null,
        public mixed $locale = null,
        public mixed $precision = null,
        public mixed $mode = 'cents',
        public bool $invalid = false,
        public mixed $size = null,
        public mixed $controlId = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.input.currency';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $invalid = $this->invalid || $fieldInvalid || stencil_field_has_errors($this->name);

        $resolvedControlId = $this->attributes->get('id')
            ?? $this->controlId
            ?? (filled($this->name) ? $this->name : null);

        $currencyCode = filled($this->currency) ? (string) $this->currency : Number::defaultCurrency();
        $localeCode = filled($this->locale) ? (string) $this->locale : Number::defaultLocale();

        if (! filled($localeCode)) {
            $localeCode = str_replace('-', '_', (string) app()->getLocale());
        }

        $fractionDigits = $this->precision ?? 2;
        $fractionDigits = max(0, (int) $fractionDigits);

        $mode = in_array($this->mode, ['cents', 'decimal'], true) ? $this->mode : 'cents';

        $numericValue = null;

        if ($this->value !== null && $this->value !== '') {
            if (is_numeric($this->value)) {
                $numericValue = (float) $this->value;
            }
        }

        $displayValue = $numericValue !== null
            ? Number::currency($numericValue, $currencyCode, $localeCode, $this->precision)
            : '';

        $hiddenValue = $numericValue !== null
            ? number_format($numericValue, $fractionDigits, '.', '')
            : '';

        $localeForJs = str_replace('_', '-', $localeCode);
        $userClass = $this->attributes->get('class');
        $applyFullWidth = ! filled($userClass);

        $controlClasses = collect([
            'input__control',
            'input-currency__control',
            'flex w-full min-w-0',
            stencil_field_surface_classes($this->size),
            'placeholder:text-zinc-500 dark:placeholder:text-zinc-400',
            stencil_invalid_field_classes(),
            $invalid ? 'border-red-500 focus-visible:ring-red-500/20 dark:border-red-500' : null,
        ])->filter()->implode(' ');

        $wrapperClasses = collect([
            'input',
            'input-currency',
            'relative flex min-w-0 items-stretch overflow-visible',
            $applyFullWidth ? 'w-full' : null,
            $userClass,
        ])->filter()->implode(' ');

        $controlExtraClass = $this->attributes->get('class:input') ?? $this->attributes->get('input:class');

        $controlAttributes = stencil_apply_interaction($this->attributes
            ->except(['class', 'class:input', 'input:class', 'name', 'value', 'currency', 'locale', 'precision', 'mode', 'id'])
            ->class([$controlClasses, $controlExtraClass])
            ->merge([
                'type' => 'text',
                'inputmode' => 'numeric',
                'autocomplete' => 'off',
                'value' => $displayValue,
                'data-input-control' => true,
                'data-input-currency-display' => true,
            ]),
        );

        if (filled($resolvedControlId)) {
            $controlAttributes = $controlAttributes->merge(['id' => $resolvedControlId]);
        }

        if ($invalid) {
            $controlAttributes = $controlAttributes->merge(['aria-invalid' => 'true']);
        }

        $controlAttributes = stencil_merge_described_by($controlAttributes, $this->aware('describedBy'));

        return [
            'mode' => $mode,
            'localeForJs' => $localeForJs,
            'currencyCode' => $currencyCode,
            'fractionDigits' => $fractionDigits,
            'wrapperClasses' => $wrapperClasses,
            'hiddenValue' => $hiddenValue,
            'controlAttributes' => $controlAttributes,
        ];
    }
}
