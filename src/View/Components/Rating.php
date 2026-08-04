<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

use InvalidArgumentException;

final class Rating extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $value = null,
        public int $max = 5,
        public bool $invalid = false,
        public bool $disabled = false,
        public mixed $size = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.rating.index';
    }

    protected function resolveViewData(array $data = []): array
    {
        if (! filled($this->name)) {
            throw new InvalidArgumentException('The rating component requires a [name] attribute.');
        }

        $invalid = $this->invalid || $this->aware('fieldInvalid', false);
        $maxStars = max(1, min(10, $this->max));
        $currentValue = filled($this->value) ? max(0, min($maxStars, (int) $this->value)) : 0;

        $resolvedControlId = $this->attributes->get('id')
            ?? $this->aware('controlId')
            ?? $this->name;

        $rootClasses = collect([
            'rating flex min-w-0 items-center gap-1',
            'w-full' => ! filled($this->attributes->get('class')),
        ])->filter()->implode(' ');

        $rootAttributes = $this->attributes
            ->except(['name', 'value', 'max', 'invalid', 'disabled', 'size', 'id'])
            ->class($rootClasses)
            ->merge([
                'id' => $resolvedControlId,
                'data-rating' => true,
                'data-rating-max' => $maxStars,
                'role' => 'radiogroup',
                'aria-label' => __('Rating'),
            ]);

        if ($this->disabled) {
            $rootAttributes = $rootAttributes->merge([
                'data-disabled' => 'true',
                'aria-disabled' => 'true',
            ]);
        }

        if ($invalid) {
            $rootAttributes = $rootAttributes->merge([
                'data-invalid' => 'true',
                'aria-invalid' => 'true',
            ]);
        }

        $stars = [];

        for ($i = 1; $i <= $maxStars; $i++) {
            $isChecked = $i === $currentValue;

            $stars[] = [
                'value' => $i,
                'checked' => $isChecked,
                'active' => $i <= $currentValue,
                'tabStop' => $isChecked || ($currentValue === 0 && $i === 1),
            ];
        }

        return [
            'maxStars' => $maxStars,
            'currentValue' => $currentValue,
            'rootAttributes' => $rootAttributes,
            'starSize' => $this->size === 'sm' ? 'size-5' : 'size-6',
            'stars' => $stars,
        ];
    }
}
