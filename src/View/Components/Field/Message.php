<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components\Field;

use Ivanfuhr\Stencil\View\Components\StencilComponent;

final class Message extends StencilComponent
{
    public function __construct(
        public mixed $variant = 'hint',
        public bool $invalid = false,
    ) {}

    protected function stencilView(): string
    {
        return 'stencil::components.field.message';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $fieldInvalid = (bool) ($data['fieldInvalid'] ?? false);
        $isError = $this->variant === 'error' || $this->invalid || $fieldInvalid;
        $messageVariant = $isError ? 'error' : 'subtle';

        return [
            'isError' => $isError,
            'messageVariant' => $messageVariant,
        ];
    }
}
