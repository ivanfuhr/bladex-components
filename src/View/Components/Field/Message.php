<?php

declare(strict_types=1);

namespace Ivanfuhr\StdComponents\View\Components\Field;

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class Message extends StdComponent
{
    public function __construct(
        public mixed $variant = 'hint',
        public bool $invalid = false,
    ) {}

    protected function stdView(): string
    {
        return 'std-components::components.field.message';
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
