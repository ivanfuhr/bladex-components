<?php

declare(strict_types=1);

namespace Ivanfuhr\BladexComponents\Registry;

final class OwnedArtifactCompiler
{
    public const string PACKAGE_SUPPORT_NAMESPACE = 'Ivanfuhr\\BladexComponents\\Support';

    public const string OWNED_SUPPORT_NAMESPACE = 'App\\Support\\Bladex';

    public const string PACKAGE_COMPONENT_PREFIX = 'x-bladex-components::';

    public const string OWNED_COMPONENT_PREFIX = 'x-ui::';

    public function compileBlade(string $content, ?string $ownedSupportNamespace = null): string
    {
        $ownedSupportNamespace ??= self::OWNED_SUPPORT_NAMESPACE;

        $content = str_replace(self::PACKAGE_COMPONENT_PREFIX, self::OWNED_COMPONENT_PREFIX, $content);
        $content = $this->rewriteSupportNamespace($content, $ownedSupportNamespace);

        return $content;
    }

    public function compilePhpSupport(string $content, ?string $ownedSupportNamespace = null): string
    {
        return $this->rewriteSupportNamespace($content, $ownedSupportNamespace ?? self::OWNED_SUPPORT_NAMESPACE);
    }

    private function rewriteSupportNamespace(string $content, string $ownedSupportNamespace): string
    {
        $content = str_replace(self::PACKAGE_SUPPORT_NAMESPACE.'\\', $ownedSupportNamespace.'\\', $content);
        $content = str_replace(self::PACKAGE_SUPPORT_NAMESPACE, $ownedSupportNamespace, $content);

        return $content;
    }
}
