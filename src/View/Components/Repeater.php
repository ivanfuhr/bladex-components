<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

use Illuminate\Support\Arr;
use InvalidArgumentException;

final class Repeater extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $value = [],
        public int $min = 0,
        public mixed $max = null,
        public bool $sortable = false,
        public bool $invalid = false,
        public bool $disabled = false,
        public mixed $size = null,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.repeater.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        if (! filled($this->name)) {
            throw new InvalidArgumentException('The repeater component requires a [name] attribute.');
        }

        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $invalid = $this->invalid || $fieldInvalid;

        $normalizedValue = collect(Arr::wrap($this->value))
            ->map(static fn (mixed $row): array => is_array($row) ? $row : [])
            ->values()
            ->all();

        $stackKey = preg_replace('/[^a-zA-Z0-9_-]/', '-', (string) $this->name);
        $stackName = 'repeater-item-template-'.$stackKey;

        $rootClasses = collect([
            'repeater flex min-w-0 flex-col gap-3',
            'w-full' => ! filled($this->attributes->get('class')),
        ])->filter()->implode(' ');

        $rootAttributes = $this->attributes
            ->class($rootClasses)
            ->merge([
                'data-repeater' => true,
                'data-repeater-name' => $this->name,
                'data-repeater-value' => json_encode($normalizedValue, JSON_THROW_ON_ERROR),
                'data-repeater-min' => max(0, $this->min),
            ]);

        if ($this->sortable) {
            $rootAttributes = $rootAttributes->merge(['data-repeater-sortable' => true]);
        }

        if ($this->max !== null) {
            $rootAttributes = $rootAttributes->merge([
                'data-repeater-max' => max(0, (int) $this->max),
            ]);
        }

        if ($this->disabled) {
            $rootAttributes = $rootAttributes->merge(['data-disabled' => 'true']);
        }

        if ($invalid) {
            $rootAttributes = $rootAttributes->merge([
                'data-invalid' => 'true',
                'aria-invalid' => 'true',
            ]);
        }

        return [
            'invalid' => $invalid,
            'stackName' => $stackName,
            'rootAttributes' => $rootAttributes,
        ];
    }
}
