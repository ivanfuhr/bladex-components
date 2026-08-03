<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\ToggleGroup;

use Illuminate\Support\Facades\View;
use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Item extends StencilComponent
{
    public function __construct(
        public mixed $value,
        public bool $disabled = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.toggle-group.item';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $itemValue = (string) $this->value;

        $type = View::getConsumableComponentData('type', 'single');
        $variant = View::getConsumableComponentData('variant', 'default');
        $size = View::getConsumableComponentData('size', null);
        $orientation = View::getConsumableComponentData('orientation', 'horizontal');
        $spacing = View::getConsumableComponentData('spacing', 0);
        $defaultValue = View::getConsumableComponentData('defaultValue', null);

        $groupType = $type === 'multiple' ? 'multiple' : 'single';
        $groupVariant = in_array($variant, ['default', 'outline'], true) ? $variant : 'default';
        $groupSize = match ($size) {
            'sm', 'lg' => $size,
            'xs' => 'sm',
            default => 'default',
        };
        $groupSpacing = is_numeric($spacing) ? max(0, (int) $spacing) : 0;
        $groupOrientation = $orientation === 'vertical' ? 'vertical' : 'horizontal';
        $isDisabled = $this->disabled;

        $selectedValues = match (true) {
            is_array($defaultValue) => array_map(static fn ($item): string => (string) $item, $defaultValue),
            filled($defaultValue) => array_values(array_filter(array_map(
                static fn (string $item): string => trim($item),
                explode(',', (string) $defaultValue),
            ), static fn (string $item): bool => $item !== '')),
            default => [],
        };
        $isSelected = in_array($itemValue, $selectedValues, true);

        $sizeClasses = match ($groupSize) {
            'sm' => 'h-8 min-w-8 px-2 text-sm',
            'lg' => 'h-10 min-w-10 px-3 text-base',
            default => 'h-9 min-w-9 px-3 text-sm',
        };

        $variantClasses = match ($groupVariant) {
            'outline' => implode(' ', [
                'border border-zinc-200 bg-transparent shadow-none',
                'hover:bg-zinc-100 hover:text-zinc-900',
                'dark:border-zinc-800 dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
            ]),
            default => implode(' ', [
                'bg-transparent',
                'hover:bg-zinc-100 hover:text-zinc-900',
                'dark:hover:bg-zinc-800 dark:hover:text-zinc-50',
            ]),
        };

        $connectedClasses = $groupSpacing === 0
            ? collect([
                'rounded-none shadow-none',
                $groupOrientation === 'vertical'
                    ? 'first:rounded-t-md last:rounded-b-md'
                    : 'first:rounded-l-md last:rounded-r-md',
                $groupVariant === 'outline' && $groupOrientation === 'vertical'
                    ? 'border-t-0 first:border-t'
                    : null,
                $groupVariant === 'outline' && $groupOrientation === 'horizontal'
                    ? 'border-l-0 first:border-l'
                    : null,
            ])->filter()->implode(' ')
            : 'rounded-md';

        $role = $groupType === 'single' ? 'radio' : 'button';

        $itemAttributes = $this->attributes
            ->class([
                'toggle-group__item',
                'inline-flex shrink-0 items-center justify-center gap-2 whitespace-nowrap font-medium',
                'transition-colors outline-none',
                'focus:z-10 focus-visible:z-10 focus-visible:ring-2 focus-visible:ring-zinc-950/10',
                'dark:focus-visible:ring-zinc-300/20',
                'disabled:pointer-events-none disabled:opacity-50',
                'cursor-pointer',
                '[&_svg]:pointer-events-none [&_svg]:shrink-0 [&_svg:not([class*=size-])]:size-4',
                'data-[state=on]:bg-zinc-100 data-[state=on]:text-zinc-900',
                'dark:data-[state=on]:bg-zinc-800 dark:data-[state=on]:text-zinc-50',
                $sizeClasses,
                $variantClasses,
                $connectedClasses,
            ])
            ->merge([
                'role' => $role,
                'data-toggle-group-item' => true,
                'data-value' => $itemValue,
                'data-variant' => $groupVariant,
                'data-size' => $groupSize,
                'data-spacing' => (string) $groupSpacing,
                'data-state' => $isSelected ? 'on' : 'off',
                'aria-checked' => $groupType === 'single' ? ($isSelected ? 'true' : 'false') : null,
                'aria-pressed' => $groupType === 'multiple' ? ($isSelected ? 'true' : 'false') : null,
                'tabindex' => $groupType === 'single' ? ($isSelected ? '0' : '-1') : '0',
                'disabled' => $isDisabled ? true : null,
            ]);

        return [
            'itemAttributes' => $itemAttributes,
        ];
    }
}
