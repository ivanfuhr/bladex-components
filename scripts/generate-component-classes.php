<?php

declare(strict_types=1);

/**
 * Generate class components from Blade views under resources/views/components.
 *
 * Usage: php scripts/generate-component-classes.php
 */
$root = dirname(__DIR__);
$viewsRoot = $root.'/resources/views/components';
$outputRoot = $root.'/src/View/Components';

$bladeFiles = [];

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($viewsRoot, FilesystemIterator::SKIP_DOTS),
);

foreach ($iterator as $file) {
    if (! $file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    if (! str_ends_with($file->getFilename(), '.blade.php')) {
        continue;
    }

    $relative = str_replace(
        $viewsRoot.DIRECTORY_SEPARATOR,
        '',
        $file->getPathname(),
    );

    $bladeFiles[] = str_replace(DIRECTORY_SEPARATOR, '/', $relative);
}

sort($bladeFiles);

$skipped = 0;
$generated = 0;

foreach ($bladeFiles as $bladePath) {
    [$className, $namespacePath] = resolveClassFromBladePath($bladePath);
    $viewName = bladePathToViewName($bladePath);
    $classFile = $outputRoot.'/'.$namespacePath.'/'.$className.'.php';

    if (shouldSkipClassFile($classFile)) {
        $skipped++;

        continue;
    }

    $props = extractPropsFromBlade($viewsRoot.'/'.$bladePath);
    $php = generateClassSource($className, $namespacePath, $viewName, $props);

    if (! is_dir(dirname($classFile))) {
        mkdir(dirname($classFile), 0755, true);
    }

    file_put_contents($classFile, $php);
    $generated++;
}

echo "Generated {$generated} component classes (skipped {$skipped} with custom resolveViewData).\n";

function shouldSkipClassFile(string $classFile): bool
{
    if (! is_file($classFile)) {
        return false;
    }

    $contents = file_get_contents($classFile);

    if ($contents === false) {
        return false;
    }

    return (bool) preg_match(
        '/protected function resolveViewData\([^)]*\)\s*:\s*array\s*\{[^}]*[^\s\}]/s',
        $contents,
    );
}

/**
 * @return array{0: string, 1: string}
 */
function resolveClassFromBladePath(string $bladePath): array
{
    $path = preg_replace('/\.blade\.php$/', '', $bladePath) ?? $bladePath;

    if (str_ends_with($path, '/index')) {
        $path = substr($path, 0, -strlen('/index'));
    }

    $segments = explode('/', $path);
    $classSegments = array_map(kebabToPascal(...), $segments);
    $className = array_pop($classSegments);
    $namespacePath = implode('/', $classSegments);

    $className = reservedClassName($className);

    return [$className, $namespacePath];
}

function reservedClassName(string $className): string
{
    return match ($className) {
        'List' => 'ListView',
        'Empty' => 'EmptyState',
        'Switch' => 'SwitchControl',
        default => $className,
    };
}

function bladePathToViewName(string $bladePath): string
{
    $view = preg_replace('/\.blade\.php$/', '', $bladePath) ?? $bladePath;

    return 'std-components::components.'.str_replace('/', '.', $view);
}

function kebabToPascal(string $segment): string
{
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $segment)));
}

/**
 * @return list<array{name: string, default: ?string, type: string}>
 */
function extractPropsFromBlade(string $path): array
{
    $contents = file_get_contents($path);

    if ($contents === false || ! preg_match('/@props\(\[(.*?)\]\)/s', $contents, $match)) {
        return [];
    }

    $props = [];
    $block = $match[1];

    foreach (preg_split('/,\s*(?=(?:\'[^\']*\'|"[^"]*")?\s*=>)/', trim($block)) as $line) {
        $line = trim($line, " \t\n\r\0\x0B,");

        if ($line === '') {
            continue;
        }

        if (preg_match("/^'([^']+)'\s*=>\s*(.+)$/", $line, $propMatch)) {
            $name = $propMatch[1];
            $default = trim($propMatch[2]);
            $type = inferPropType($name, $default);
            $props[] = ['name' => $name, 'default' => $default, 'type' => $type];
        }
    }

    return $props;
}

function inferPropType(string $name, string $default): string
{
    if (preg_match('/^(true|false)$/', $default)) {
        return 'bool';
    }

    if (preg_match('/^\d+$/', $default)) {
        return 'int';
    }

    return 'mixed';
}

/**
 * @param  list<array{name: string, default: ?string, type: string}>  $props
 */
function generateClassSource(string $className, string $namespacePath, string $viewName, array $props): string
{
    $namespace = 'Ivanfuhr\\StdComponents\\View\\Components';

    if ($namespacePath !== '') {
        $namespace .= '\\'.str_replace('/', '\\', $namespacePath);
    }

    $constructorParams = [];

    foreach ($props as $prop) {
        $default = formatDefault($prop['default'], $prop['type']);
        $constructorParams[] = "        public {$prop['type']} \${$prop['name']} = {$default},";
    }

    $constructor = $constructorParams === []
        ? ''
        : "\n    public function __construct(\n".implode("\n", $constructorParams)."\n    ) {}\n";

    return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use Ivanfuhr\StdComponents\View\Components\StdComponent;

final class {$className} extends StdComponent
{{$constructor}
    protected function stdView(): string
    {
        return '{$viewName}';
    }
}

PHP;
}

function formatDefault(?string $default, string $type): string
{
    if ($default === null) {
        return match ($type) {
            'bool' => 'false',
            'int' => '0',
            'mixed' => 'null',
            default => "''",
        };
    }

    if ($type === 'bool') {
        return $default === 'true' ? 'true' : 'false';
    }

    if ($type === 'int') {
        return $default;
    }

    if ($default === 'null') {
        return 'null';
    }

    if (preg_match('/^\'(.*)\'$/', $default, $match)) {
        return "'".addslashes($match[1])."'";
    }

    return $default;
}
