<?php

declare(strict_types=1);

namespace Ivanfuhr\Stencil\Registry;

use RuntimeException;

final class OwnedArtifactCompiler
{
    public const string PACKAGE_SUPPORT_NAMESPACE = 'Ivanfuhr\\Stencil\\Support';

    public const string OWNED_SUPPORT_NAMESPACE = 'App\\Support\\Stencil';

    public const string PACKAGE_COMPONENT_PREFIX = 'x-stencil::';

    public const string OWNED_COMPONENT_PREFIX = 'x-ui::';

    public const string PACKAGE_TRANSLATION_NAMESPACE = 'stencil::messages';

    public const string OWNED_TRANSLATION_NAMESPACE = 'stencil-ui::messages';

    public function compileBlade(string $content, ?string $ownedSupportNamespace = null): string
    {
        $ownedSupportNamespace ??= self::OWNED_SUPPORT_NAMESPACE;

        $content = $this->inlineInternalLoadingIconInclude($content, $ownedSupportNamespace);
        $content = str_replace(self::PACKAGE_COMPONENT_PREFIX, self::OWNED_COMPONENT_PREFIX, $content);
        $content = $this->rewriteSupportNamespace($content, $ownedSupportNamespace);
        $content = $this->rewriteTranslationNamespace($content);

        return $content;
    }

    public function compilePhpSupport(string $content, ?string $ownedSupportNamespace = null): string
    {
        $content = $this->rewriteSupportNamespace($content, $ownedSupportNamespace ?? self::OWNED_SUPPORT_NAMESPACE);

        return $this->rewriteTranslationNamespace($content);
    }

    private function rewriteTranslationNamespace(string $content): string
    {
        return str_replace(
            self::PACKAGE_TRANSLATION_NAMESPACE,
            self::OWNED_TRANSLATION_NAMESPACE,
            $content,
        );
    }

    private function rewriteSupportNamespace(string $content, string $ownedSupportNamespace): string
    {
        $content = str_replace(self::PACKAGE_SUPPORT_NAMESPACE.'\\', $ownedSupportNamespace.'\\', $content);
        $content = str_replace(self::PACKAGE_SUPPORT_NAMESPACE, $ownedSupportNamespace, $content);

        return $content;
    }

    private function inlineInternalLoadingIconInclude(string $content, string $ownedSupportNamespace): string
    {
        if (! str_contains($content, 'stencil::internals.loading-icon')) {
            return $content;
        }

        $partialPath = dirname(__DIR__, 2).'/resources/views/internals/loading-icon.blade.php';
        $partial = file_get_contents($partialPath);

        if ($partial === false) {
            throw new RuntimeException("Unable to read internal loading icon partial: {$partialPath}");
        }

        $partial = $this->compileBlade($partial, $ownedSupportNamespace);

        $pattern = "/@include\\(\\s*'stencil::internals\\.loading-icon'(?:\\s*,\\s*\\[[^\\]]*\\])?\\s*\\)/s";

        return (string) preg_replace($pattern, $partial, $content);
    }
}
