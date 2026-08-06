<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components;

use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\ComponentSlot;

final class Input extends StdComponent
{
    public function __construct(
        public mixed $type = 'text',
        public bool $invalid = false,
        public mixed $size = null,
        public bool $inGroup = false,
        public mixed $prefix = null,
        public mixed $suffix = null,
        public mixed $leading = null,
        public mixed $trailing = null,
        public mixed $mask = null,
        public bool $viewable = false,
        public bool $copyable = false,
        public bool $counter = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.input.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $invalid = $this->invalid || $fieldInvalid || std_field_has_errors($this->attributes->get('name'));

        $explicitControlId = $this->attributes->get('controlId')
            ?? $this->attributes->get('control-id');

        $resolvedControlId = $this->attributes->get('id')
            ?? (filled($explicitControlId) ? $explicitControlId : $this->aware('controlId'))
            ?? $this->attributes->get('name');
        $userClass = $this->attributes->get('class');
        $applyFullWidth = ! filled($userClass);

        $prefixText = filled($this->prefix) ? $this->prefix : null;
        $suffixText = filled($this->suffix) ? $this->suffix : null;
        $hasGroupAffix = $prefixText !== null || $suffixText !== null;
        $useInGroup = $this->inGroup || $hasGroupAffix;

        $resolveAffix = static function (mixed $value): array {
            if ($value instanceof ComponentSlot) {
                return [! $value->isEmpty(), $value->isEmpty() ? null : $value];
            }

            if (filled($value)) {
                return [true, $value];
            }

            return [false, null];
        };

        $leading = $data['leading'] ?? $this->leading;
        $trailing = $data['trailing'] ?? $this->trailing;

        [$hasLeading, $leadingContent] = $resolveAffix($leading);
        [$hasTrailing, $trailingContent] = $resolveAffix($trailing);

        $hasViewable = $this->viewable && $this->type === 'password';
        $hasCopyable = (bool) $this->copyable;
        $hasCounter = (bool) $this->counter;
        $hasMask = filled($this->mask);
        $hasEnhancements = $hasViewable || $hasCopyable || $hasCounter || $hasMask;

        $trailingSlotIsIcon = false;

        if ($hasTrailing && $trailingContent instanceof ComponentSlot && ! $trailingContent->isEmpty()) {
            $trailingSlotIsIcon = str_contains($trailingContent->toHtml(), 'data-icon');
        }

        $trailingAffixWidth = $trailingSlotIsIcon ? 'w-9' : 'w-14';

        $leadingControlPadding = $hasLeading ? '!pl-9' : null;

        $trailingControlPadding = match (true) {
            ! $hasTrailing && ! $hasViewable && ! $hasCopyable => null,
            $hasTrailing && $trailingSlotIsIcon => '!pr-9',
            $hasTrailing => '!pr-14',
            $hasViewable && $hasCopyable => '!pr-[4.5rem]',
            $hasViewable || $hasCopyable => '!pr-9',
            default => null,
        };

        $controlClasses = collect([
            'input__control',
            'flex w-full min-w-0',
            std_field_surface_classes($this->size),
            'placeholder:text-zinc-500 dark:placeholder:text-zinc-400',
            std_invalid_field_classes(),
            $leadingControlPadding,
            $trailingControlPadding,
            $invalid ? 'border-red-500 focus-visible:ring-red-500/20 dark:border-red-500' : null,
            $useInGroup ? 'shadow-none focus-visible:z-10' : null,
            $prefixText !== null && $suffixText !== null ? 'rounded-none border-l-0 border-r-0' : null,
            $prefixText !== null && $suffixText === null ? 'rounded-l-none border-l-0' : null,
            $suffixText !== null && $prefixText === null ? 'rounded-r-none border-r-0' : null,
            $useInGroup && ! $hasGroupAffix ? 'rounded-none' : null,
        ])->filter()->implode(' ');

        $wrapperClasses = collect([
            'input',
            'relative flex min-w-0 items-stretch overflow-visible',
            $hasCounter ? 'flex-wrap' : null,
            $applyFullWidth && ! $hasGroupAffix ? 'w-full' : null,
            $hasGroupAffix ? 'flex-1' : null,
            $hasLeading || $hasTrailing || $hasViewable || $hasCopyable ? 'input--with-affixes' : null,
            ! $hasGroupAffix ? $userClass : null,
        ])->filter()->implode(' ');

        $controlExtraClass = $this->attributes->get('class:input') ?? $this->attributes->get('input:class');

        $controlAttributes = std_apply_interaction($this->attributes
            ->except(['class', 'class:input', 'input:class', 'prefix', 'suffix', 'leading', 'trailing', 'mask', 'viewable', 'copyable', 'counter', 'id'])
            ->class([$controlClasses, $controlExtraClass])
            ->merge([
                'type' => $this->type,
                'data-input-control' => true,
            ]),
        );

        if (filled($resolvedControlId)) {
            $controlAttributes = $controlAttributes->merge(['id' => $resolvedControlId]);
        }

        if ($hasMask) {
            $controlAttributes = $controlAttributes->merge([
                'data-input-mask-control' => true,
            ]);
        }

        if ($invalid) {
            $controlAttributes = $controlAttributes->merge(['aria-invalid' => 'true']);
        }

        $affixIconClasses = $this->size === 'sm'
            ? '[&_[data-icon]]:size-3.5'
            : '[&_[data-icon]]:size-4';

        $leadingAffixClasses = collect([
            'input__leading',
            'pointer-events-none absolute inset-y-0 left-0 flex w-9 items-center justify-center',
            $affixIconClasses,
            '[&_[data-icon]]:text-zinc-500 dark:[&_[data-icon]]:text-zinc-400',
        ])->implode(' ');

        $trailingAffixClasses = collect([
            'input__trailing',
            'absolute inset-y-0 right-0 z-10 flex items-center justify-center',
            $trailingAffixWidth,
            $affixIconClasses,
            '[&_[data-icon]]:text-zinc-500 dark:[&_[data-icon]]:text-zinc-400',
        ])->implode(' ');

        $wrapperTagAttributes = (new ComponentAttributeBag([
            'data-input' => true,
        ]))->class($wrapperClasses);

        if ($hasEnhancements) {
            $wrapperTagAttributes = $wrapperTagAttributes->merge(['data-input-enhanced' => true]);
        }

        if ($hasMask) {
            $wrapperTagAttributes = $wrapperTagAttributes->merge(['data-input-mask' => $this->mask]);
        }

        if ($hasViewable) {
            $wrapperTagAttributes = $wrapperTagAttributes->merge(['data-input-viewable' => true]);
        }

        if ($hasCopyable) {
            $wrapperTagAttributes = $wrapperTagAttributes->merge(['data-input-copyable' => true]);
        }

        if ($hasCounter) {
            $wrapperTagAttributes = $wrapperTagAttributes->merge(['data-input-counter' => true]);
        }

        $controlAttributes = std_merge_described_by($controlAttributes, $this->aware('describedBy'));

        return [
            'fieldInvalid' => $fieldInvalid,
            'invalid' => $invalid,
            'userClass' => $userClass,
            'hasGroupAffix' => $hasGroupAffix,
            'hasLeading' => $hasLeading,
            'leadingContent' => $leadingContent,
            'hasTrailing' => $hasTrailing,
            'trailingContent' => $trailingContent,
            'hasViewable' => $hasViewable,
            'hasCopyable' => $hasCopyable,
            'hasCounter' => $hasCounter,
            'prefixText' => $prefixText,
            'suffixText' => $suffixText,
            'controlAttributes' => $controlAttributes,
            'leadingAffixClasses' => $leadingAffixClasses,
            'trailingAffixClasses' => $trailingAffixClasses,
            'wrapperTagAttributes' => $wrapperTagAttributes,
        ];
    }
}
