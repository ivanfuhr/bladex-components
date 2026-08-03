<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use ReflectionClass;
use ReflectionProperty;
use Throwable;

abstract class StencilComponent extends Component
{
    /**
     * @var array<string, mixed>|null
     */
    private ?array $resolvedViewDataCache = null;

    /**
     * @return view-string
     */
    abstract protected function stencilView(): string;

    /**
     * @return array<string, mixed>
     */
    public function data()
    {
        if ($this->attributes === null) {
            $this->attributes = $this->newAttributeBag();
        }

        $base = parent::data();

        try {
            foreach ($this->computedViewData($base) as $key => $value) {
                if (array_key_exists($key, $base)) {
                    $base[$key] = $value;
                }
            }
        } catch (Throwable) {
            // resolveViewData may require slot or ancestor context not yet available.
        }

        return $base;
    }

    public function render(): Closure
    {
        return function (array $data): View {
            return view($this->stencilView(), array_merge(
                $data,
                $this->publicPropertyValues(),
                $this->computedViewData($data),
            ));
        };
    }

    /**
     * @return array<string, mixed>
     */
    protected function publicPropertyValues(): array
    {
        $values = [];

        foreach ((new ReflectionClass($this))->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if ($property->isStatic()) {
                continue;
            }

            $values[$property->getName()] = $property->getValue($this);
        }

        return $values;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        return [];
    }

    /**
     * Resolve a value shared by an ancestor component, mirroring Blade's @aware directive.
     */
    protected function aware(string $key, mixed $default = null): mixed
    {
        return $this->factory()->getConsumableComponentData($key, $default);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function computedViewData(array $data = []): array
    {
        if ($data === [] && $this->resolvedViewDataCache !== null) {
            return $this->resolvedViewDataCache;
        }

        $resolved = $this->resolveViewData($data);

        if ($data === []) {
            $this->resolvedViewDataCache = $resolved;
        }

        return $resolved;
    }
}
