<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Support\Interaction;

use Illuminate\View\ComponentAttributeBag;

final class InteractionStateAttributes
{
    public function isActive(ComponentAttributeBag $attributes, string $key): bool
    {
        if (! $attributes->offsetExists($key)) {
            return false;
        }

        $value = $attributes->get($key);

        return ! in_array($value, [false, 'false', 0, '0', null], true);
    }

    public function isLoading(ComponentAttributeBag $attributes): bool
    {
        return $this->isActive($attributes, 'data-loading')
            || $this->isTruthyAriaBusy($attributes);
    }

    public function isDisabled(ComponentAttributeBag $attributes): bool
    {
        return $this->isActive($attributes, 'disabled')
            || $this->isActive($attributes, 'aria-disabled');
    }

    /**
     * @param  array{
     *     nativeDisabled?: bool,
     *     loading?: bool|null,
     * }  $options
     */
    public function apply(ComponentAttributeBag $attributes, array $options = []): ComponentAttributeBag
    {
        $nativeDisabled = $options['nativeDisabled'] ?? true;
        $loading = $options['loading'] ?? null;

        if ($loading === true) {
            $attributes = $attributes->merge(['data-loading' => true]);
        }

        if ($this->isLoading($attributes)) {
            $attributes = $attributes->merge(['aria-busy' => 'true']);
        }

        if (! $nativeDisabled && $this->isDisabled($attributes)) {
            return $attributes
                ->except('disabled')
                ->merge([
                    'aria-disabled' => 'true',
                    'tabindex' => '-1',
                ]);
        }

        return $attributes;
    }

    private function isTruthyAriaBusy(ComponentAttributeBag $attributes): bool
    {
        if (! $attributes->offsetExists('aria-busy')) {
            return false;
        }

        $value = $attributes->get('aria-busy');

        return ! in_array($value, [false, 'false', 0, '0', null, ''], true);
    }
}
