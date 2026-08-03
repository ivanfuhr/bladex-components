<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\View\Components;

use Illuminate\View\ComponentAttributeBag;
use RuntimeException;

final class Icon extends StencilComponent
{
    public function __construct(
        public string $name = '',
        public string $variant = 'outline',
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function resolve($data)
    {
        if (($data['name'] ?? '') === '' && isset($data['attributes']) && $data['attributes'] instanceof ComponentAttributeBag) {
            $data['name'] = (string) $data['attributes']->get('name', '');
        }

        return parent::resolve($data);
    }

    protected function stencilView(): string
    {
        return 'stencil::components.icon.index';
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function resolveViewData(array $data = []): array
    {
        $name = $this->name !== '' ? $this->name : (string) ($data['name'] ?? $this->attributes->get('name', ''));

        $resolvedName = stencil_normalize_icon_name($name);
        $iconPath = stencil_resolved_icons_path().'/'.$resolvedName.'.blade.php';

        if (! is_file($iconPath)) {
            throw new RuntimeException("Icon [{$resolvedName}] is not installed. Run: php artisan stencil:icon {$resolvedName}");
        }

        return [
            'icon' => $resolvedName,
            'variant' => $this->variant,
        ];
    }
}
