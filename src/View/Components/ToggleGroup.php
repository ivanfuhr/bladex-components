<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

final class ToggleGroup extends StdComponent
{
    public function __construct(
        public mixed $type = 'single',
        public mixed $variant = 'default',
        public mixed $size = null,
        public mixed $orientation = 'horizontal',
        public int $spacing = 0,
        public mixed $defaultValue = null,
        public bool $disabled = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.toggle-group.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $type = $this->type === 'multiple' ? 'multiple' : 'single';
        $variant = in_array($this->variant, ['default', 'outline'], true) ? $this->variant : 'default';
        $size = match ($this->size) {
            'sm', 'lg' => $this->size,
            'xs' => 'sm',
            default => 'default',
        };
        $orientation = $this->orientation === 'vertical' ? 'vertical' : 'horizontal';
        $spacing = max(0, $this->spacing);
        $isDisabled = $this->disabled;

        $initialValue = match (true) {
            is_array($this->defaultValue) => implode(',', array_map(static fn (mixed $item): string => (string) $item, $this->defaultValue)),
            filled($this->defaultValue) => (string) $this->defaultValue,
            default => '',
        };

        $role = $type === 'single' ? 'radiogroup' : 'group';

        $rootAttributes = $this->attributes
            ->class([
                'toggle-group',
                'group/toggle-group flex w-fit items-center rounded-md',
                $orientation === 'vertical' ? 'flex-col' : 'flex-row',
                $spacing > 0 ? 'gap-[length:var(--toggle-gap)]' : null,
                $spacing === 0 && $variant === 'outline' ? 'shadow-sm' : null,
            ])
            ->merge([
                'role' => $role,
                'data-toggle-group' => true,
                'data-type' => $type,
                'data-variant' => $variant,
                'data-size' => $size,
                'data-orientation' => $orientation,
                'data-spacing' => (string) $spacing,
                'data-value' => $initialValue !== '' ? $initialValue : null,
                'data-disabled' => $isDisabled ? 'true' : null,
                'aria-disabled' => $isDisabled ? 'true' : null,
                'aria-orientation' => $orientation,
                'style' => $spacing > 0 ? '--toggle-gap: '.$spacing * 0.25.'rem' : null,
            ]);

        return [
            'rootAttributes' => $rootAttributes,
            'isDisabled' => $isDisabled,
        ];
    }
}
