<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Registry;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;

final class SupportStubGenerator
{
    /** @var list<string> */
    private const array SUPPORT_FILES = [
        'Button/ButtonClassMap.php',
        'Form/FormControlClassMap.php',
        'Interaction/InteractionStateAttributes.php',
        'Interaction/InteractionStateClassMap.php',
        'Typography/TypographyClassMap.php',
        'Typography/TypographyConfig.php',
        'Typography/TypographyScale.php',
        'Typography/GoogleFontsStylesheetBuilder.php',
        'Icon/IconPathResolver.php',
        'Icon/IconVariant.php',
        'ProjectConfig.php',
    ];

    public function __construct(
        private readonly OwnedArtifactCompiler $compiler,
    ) {}

    public function generate(string $packageRoot, string $stubsRoot): void
    {
        $supportSource = $packageRoot.'/src/Support';
        $supportTarget = $stubsRoot.'/support/Stencil';

        if (! is_dir($supportSource)) {
            throw new RuntimeException("Package support path not found: {$supportSource}");
        }

        $this->deleteDirectory($supportTarget);
        $this->ensureDirectoryExists($supportTarget);

        foreach (self::SUPPORT_FILES as $relative) {
            $source = $supportSource.'/'.$relative;

            if (! is_file($source)) {
                throw new RuntimeException("Missing support source file: {$source}");
            }

            $content = file_get_contents($source);

            if ($content === false) {
                throw new RuntimeException("Unable to read support source: {$source}");
            }

            $content = $this->compiler->compilePhpSupport($content);
            $content = $this->patchOwnedSupportFile($relative, $content);

            $target = $supportTarget.'/'.str_replace('/', DIRECTORY_SEPARATOR, $relative);
            $this->ensureDirectoryExists(dirname($target));
            file_put_contents($target, $content);
        }

        $this->writeStaticStubs($packageRoot, $stubsRoot);
    }

    private function patchOwnedSupportFile(string $relative, string $content): string
    {
        if ($relative === 'Typography/TypographyConfig.php') {
            $content = str_replace(
                "\$base = config('stencil.typography', []);",
                '$base = config(\'stencil-ui.typography\', []);',
                $content,
            );
        }

        if ($relative === 'Icon/IconPathResolver.php') {
            $content = str_replace(
                <<<'PHP'
        $template = (string) config(
            'stencil.lucide_raw_url',
            'https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/{name}.svg',
        );
PHP,
                <<<'PHP'
        $template = (string) config(
            'stencil-ui.lucide_raw_url',
            'https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/{name}.svg',
        );
PHP,
                $content,
            );
        }

        return $content;
    }

    private function writeStaticStubs(string $packageRoot, string $stubsRoot): void
    {
        $cssTarget = $stubsRoot.'/resources/css/stencil.css';
        $this->ensureDirectoryExists(dirname($cssTarget));
        file_put_contents($cssTarget, <<<'CSS'
/**
 * Stencil — Tailwind v4 @source paths for owned UI.
 */
@custom-variant dark (&:where(.dark, .dark *));

@source "../../views/**/*.blade.php";
@source "../../../app/Support/Stencil/**/*.php";

CSS);

        $fontsSource = $packageRoot.'/resources/views/components/fonts.blade.php';
        $fontsContent = file_get_contents($fontsSource);

        if ($fontsContent === false) {
            throw new RuntimeException('Unable to read fonts component source.');
        }

        $fontsContent = $this->compiler->compileBlade($fontsContent);
        $fontsTarget = $stubsRoot.'/resources/views/ui/fonts.blade.php';
        $this->ensureDirectoryExists(dirname($fontsTarget));
        file_put_contents($fontsTarget, $fontsContent);

        $configTarget = $stubsRoot.'/config/stencil-ui.php';
        $this->ensureDirectoryExists(dirname($configTarget));
        /** @var array<string, mixed> $packageConfig */
        $packageConfig = require $packageRoot.'/config/stencil.php';
        $typography = $packageConfig['typography'] ?? [];
        $typographyJson = json_encode($typography, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if ($typographyJson === false) {
            throw new RuntimeException('Unable to encode typography defaults for stencil-ui stub.');
        }

        file_put_contents($configTarget, <<<PHP
<?php

declare(strict_types=1);

return [
    'lucide_raw_url' => 'https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/{name}.svg',

    'typography' => json_decode(<<<'JSON'
{$typographyJson}
JSON, true),
];

PHP);

        $providerTarget = $stubsRoot.'/app/Providers/StencilUiServiceProvider.php';
        $this->ensureDirectoryExists(dirname($providerTarget));
        file_put_contents($providerTarget, <<<'PHP'
<?php

declare(strict_types=1);

namespace App\Providers;

use App\Support\Stencil\Button\ButtonClassMap;
use App\Support\Stencil\Form\FormControlClassMap;
use App\Support\Stencil\Interaction\InteractionStateAttributes;
use App\Support\Stencil\Interaction\InteractionStateClassMap;
use App\Support\Stencil\ProjectConfig;
use App\Support\Stencil\Typography\GoogleFontsStylesheetBuilder;
use App\Support\Stencil\Typography\TypographyClassMap;
use App\Support\Stencil\Typography\TypographyConfig;
use App\Support\Stencil\Typography\TypographyScale;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class StencilUiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (is_file(config_path('stencil-ui.php'))) {
            $this->mergeConfigFrom(config_path('stencil-ui.php'), 'stencil-ui');
        }

        $this->app->bind(ProjectConfig::class, fn ($app) => new ProjectConfig($app));
        $this->app->singleton(TypographyConfig::class);
        $this->app->singleton(TypographyScale::class);
        $this->app->singleton(TypographyClassMap::class);
        $this->app->singleton(ButtonClassMap::class);
        $this->app->singleton(FormControlClassMap::class);
        $this->app->singleton(InteractionStateClassMap::class);
        $this->app->singleton(InteractionStateAttributes::class);
        $this->app->singleton(GoogleFontsStylesheetBuilder::class);
    }

    public function boot(): void
    {
        $uiPath = app(ProjectConfig::class)->resolvedUiPath();

        if (is_dir($uiPath)) {
            Blade::anonymousComponentPath($uiPath, 'ui');
        }
    }
}

PHP);
    }

    private function ensureDirectoryExists(string $path): void
    {
        if (is_dir($path)) {
            return;
        }

        if (! mkdir($path, 0755, true) && ! is_dir($path)) {
            throw new RuntimeException("Unable to create directory: {$path}");
        }
    }

    private function deleteDirectory(string $path): void
    {
        if (! is_dir($path)) {
            return;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST,
        );

        foreach ($iterator as $file) {
            if ($file->isDir()) {
                rmdir($file->getPathname());
            } else {
                unlink($file->getPathname());
            }
        }

        rmdir($path);
    }
}
