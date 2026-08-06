<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Radio;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Group extends StdComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $value = null,
        public mixed $legend = null,
        public bool $invalid = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.radio.group';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $isInvalid = $this->invalid || $fieldInvalid;

        $groupAttributes = $this->attributes
            ->class([
                'radio-group',
                'flex flex-col gap-3',
            ])
            ->merge([
                'data-radio-group' => true,
            ]);

        return [
            'groupAttributes' => $groupAttributes,
        ];
    }
}
