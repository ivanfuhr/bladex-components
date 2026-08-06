<?php

declare(strict_types=1);

namespace Workbench\App\Playbook;

final class PlaybookCode
{
    /** Blade tag prefix shown in playbook snippets (owned / registry install). */
    public const string COMPONENT_PREFIX = 'x-std::';

    public static function component(string $name): string
    {
        return self::COMPONENT_PREFIX.$name;
    }

    public static function boolean(string $name, bool $value, bool $default = false): ?string
    {
        if ($value === $default) {
            return null;
        }

        return ':'.$name.'="'.($value ? 'true' : 'false').'"';
    }

    public static function attribute(string $name, mixed $value, mixed $default = null): ?string
    {
        if ($value === null || $value === '' || $value === $default) {
            return null;
        }

        if (is_bool($value)) {
            return self::boolean($name, $value);
        }

        $string = (string) $value;

        if (str_contains($string, '"')) {
            return $name.'=\''.self::escapeSingleQuotedHtml($string).'\'';
        }

        return $name.'="'.self::escapeDoubleQuotedHtml($string).'"';
    }

    public static function bound(string $name, mixed $value, mixed $default = null): ?string
    {
        if ($value === null || $value === '' || $value === $default) {
            return null;
        }

        if (is_bool($value)) {
            return self::boolean($name, $value);
        }

        if (is_int($value) || is_float($value)) {
            return ':'.$name.'="'.$value.'"';
        }

        return ':'.$name.'="'.self::bladeSingleQuotedLiteral((string) $value).'"';
    }

    /**
     * @param  list<string|null>  $attributes
     */
    public static function openingTag(string $component, array $attributes): string
    {
        $lines = array_values(array_filter($attributes));

        if ($lines === []) {
            return '<'.$component.'>';
        }

        return '<'.$component."\n    ".implode("\n    ", $lines)."\n>";
    }

    /**
     * @param  list<string|null>  $attributes
     */
    public static function selfClosingTag(string $component, array $attributes = []): string
    {
        $lines = array_values(array_filter($attributes));

        if ($lines === []) {
            return '<'.$component.' />';
        }

        return '<'.$component."\n    ".implode("\n    ", $lines)."\n/>";
    }

    public static function closingTag(string $component): string
    {
        return '</'.$component.'>';
    }

    private static function escapeDoubleQuotedHtml(string $value): string
    {
        return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
    }

    private static function escapeSingleQuotedHtml(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    /** PHP single-quoted literal safe inside a Blade :attr="…" binding. */
    private static function bladeSingleQuotedLiteral(string $value): string
    {
        return "'".str_replace("'", "\\'", $value)."'";
    }
}
