@props([
    'name',
    'variant' => 'outline',
])

@php
    use Ivanfuhr\Stencil\Support\Icon\IconPathResolver;
    use Ivanfuhr\Stencil\Support\ProjectConfig;

    $resolvedName = IconPathResolver::normalizeName((string) $name);
    $iconPath = app(ProjectConfig::class)->resolvedIconsPath().'/'.$resolvedName.'.blade.php';

    if (! is_file($iconPath)) {
        throw new \RuntimeException("Icon [{$resolvedName}] is not installed. Run: php artisan stencil:icon {$resolvedName}");
    }

    $componentName = 'ui::icons.'.$resolvedName;
@endphp

<x-dynamic-component :component="$componentName" :variant="$variant" {{ $attributes }} />
