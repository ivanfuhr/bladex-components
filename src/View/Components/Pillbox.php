<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use InvalidArgumentException;

final class Pillbox extends StdComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $value = [],
        public mixed $placeholder = null,
        public mixed $max = null,
        public bool $invalid = false,
        public bool $disabled = false,
        public mixed $size = null,
        public mixed $controlId = null,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.pillbox.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        if (! filled($this->name)) {
            throw new InvalidArgumentException('The pillbox component requires a [name] attribute.');
        }

        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $invalid = $this->invalid || $fieldInvalid;

        $resolvedControlId = $this->attributes->get('id')
            ?? $this->controlId
            ?? $this->name;

        $fieldName = Str::endsWith($this->name, '[]') ? $this->name : $this->name.'[]';

        $normalizedValue = collect(Arr::wrap($this->value))
            ->filter(fn (mixed $item): bool => filled($item))
            ->map(fn (mixed $item): string => (string) $item)
            ->values()
            ->all();

        $resolvedPlaceholder = filled($this->placeholder)
            ? $this->placeholder
            : __('Add tags…');

        $rootClasses = collect([
            'pillbox flex min-w-0 flex-col gap-2',
            'w-full' => ! filled($this->attributes->get('class')),
        ])->filter()->implode(' ');

        $rootAttributes = $this->attributes
            ->except(['name', 'value', 'placeholder', 'max', 'invalid', 'disabled', 'size', 'id'])
            ->class($rootClasses)
            ->merge([
                'data-pillbox' => true,
                'data-pillbox-name' => $fieldName,
                'data-pillbox-value' => json_encode($normalizedValue, JSON_THROW_ON_ERROR),
                'data-pillbox-chip-remove-label' => __('Remove tag'),
            ]);

        if ($this->max !== null) {
            $rootAttributes = $rootAttributes->merge([
                'data-pillbox-max' => max(1, (int) $this->max),
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

        $chipSizeClasses = $this->size === 'sm'
            ? 'text-xs px-1.5 py-0'
            : 'text-xs px-2 py-0.5';

        $chipClasses = collect([
            'pillbox__chip',
            'inline-flex max-w-full items-center gap-1 rounded-md border border-zinc-200 bg-zinc-50 font-medium text-zinc-700',
            'dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200',
            $chipSizeClasses,
        ])->implode(' ');

        $chipRemoveClasses = collect([
            'pillbox__chip-remove',
            'inline-flex shrink-0 items-center justify-center rounded-sm text-zinc-500 hover:text-zinc-900',
            'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950/10',
            'dark:text-zinc-400 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20',
            $this->size === 'sm' ? 'size-3.5' : 'size-4',
        ])->implode(' ');

        return [
            'invalid' => $invalid,
            'resolvedControlId' => $resolvedControlId,
            'fieldName' => $fieldName,
            'normalizedValue' => $normalizedValue,
            'resolvedPlaceholder' => $resolvedPlaceholder,
            'rootAttributes' => $rootAttributes,
            'chipClasses' => $chipClasses,
            'chipRemoveClasses' => $chipRemoveClasses,
        ];
    }
}
