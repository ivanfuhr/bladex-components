<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Radio;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Group extends StencilComponent
{
    public function __construct(
        public mixed $name = null,
        public mixed $value = null,
        public mixed $legend = null,
        public bool $invalid = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.radio.group';
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

        if ($isInvalid) {
            $groupAttributes = $groupAttributes->merge(['aria-invalid' => 'true']);
        }

        return [
            'groupAttributes' => $groupAttributes,
        ];
    }
}
