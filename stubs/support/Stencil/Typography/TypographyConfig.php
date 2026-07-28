<?php

declare(strict_types=1);

namespace App\Support\Stencil\Typography;

use Illuminate\Support\Arr;
use App\Support\Stencil\ProjectConfig;

final class TypographyConfig
{
    /** @var list<string> */
    public const array SCALE_KEYS = ['sm', 'default', 'lg', 'xl'];

    public function __construct(
        private readonly ProjectConfig $projectConfig,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        $base = config('stencil-ui.typography', []);

        if (! is_array($base)) {
            $base = [];
        }

        $project = $this->projectConfig->tryRead();
        $override = is_array($project) ? Arr::get($project, 'typography', []) : [];

        if (! is_array($override)) {
            $override = [];
        }

        return $this->mergeTypography($base, $override);
    }

    /**
     * @return array<string, array{text: string, leading: string}>
     */
    public function scale(): array
    {
        $scale = Arr::get($this->all(), 'scale', []);

        if (! is_array($scale)) {
            $scale = [];
        }

        $defaults = $this->defaultScale();
        $merged = [];

        foreach (self::SCALE_KEYS as $key) {
            $entry = is_array($scale[$key] ?? null) ? $scale[$key] : [];
            $default = $defaults[$key];

            $merged[$key] = [
                'text' => (string) ($entry['text'] ?? $default['text']),
                'leading' => (string) ($entry['leading'] ?? $default['leading']),
            ];
        }

        return $merged;
    }

    /**
     * @return array<string, mixed>
     */
    public function fonts(): array
    {
        $fonts = Arr::get($this->all(), 'fonts', []);

        return is_array($fonts) ? $fonts : [];
    }

    /**
     * @return array{body: string, heading: string}
     */
    public function roles(): array
    {
        $roles = Arr::get($this->all(), 'roles', []);

        if (! is_array($roles)) {
            $roles = [];
        }

        $body = (string) ($roles['body'] ?? 'sans');
        $heading = (string) ($roles['heading'] ?? 'sans');

        $fontKeys = array_keys($this->fonts());

        if ($heading !== '' && ! in_array($heading, $fontKeys, true)) {
            $heading = in_array('sans', $fontKeys, true) ? 'sans' : ($fontKeys[0] ?? $body);
        }

        if ($body !== '' && ! in_array($body, $fontKeys, true)) {
            $body = $fontKeys[0] ?? 'sans';
        }

        return [
            'body' => $body,
            'heading' => $heading,
        ];
    }

    public function fontFamilyKeyForRole(string $role): string
    {
        $roles = $this->roles();

        return match ($role) {
            'heading' => $roles['heading'],
            default => $roles['body'],
        };
    }

    public function defaultTextSize(): string
    {
        $defaults = Arr::get($this->all(), 'defaults', []);

        if (! is_array($defaults)) {
            $defaults = [];
        }

        $size = (string) ($defaults['text_size'] ?? 'default');

        if (! in_array($size, self::SCALE_KEYS, true)) {
            return 'default';
        }

        return $size;
    }

    public function defaultHeadingLevel(): int
    {
        $defaults = Arr::get($this->all(), 'defaults', []);

        if (! is_array($defaults)) {
            $defaults = [];
        }

        $level = (int) ($defaults['heading_level'] ?? 2);

        return max(1, min(6, $level));
    }

    /**
     * @return list<array{key: string, provider: string, family: string, weights: list<int>, subsets: list<string>}>
     */
    public function googleFontDefinitions(): array
    {
        $definitions = [];

        foreach ($this->fonts() as $key => $definition) {
            if (! is_array($definition)) {
                continue;
            }

            $provider = (string) ($definition['provider'] ?? '');

            if ($provider !== 'google') {
                continue;
            }

            $family = (string) ($definition['family'] ?? '');

            if ($family === '') {
                continue;
            }

            $weights = $definition['weights'] ?? [400];
            $subsets = $definition['subsets'] ?? ['latin'];

            if (! is_array($weights)) {
                $weights = [400];
            }

            if (! is_array($subsets)) {
                $subsets = ['latin'];
            }

            $definitions[] = [
                'key' => (string) $key,
                'provider' => 'google',
                'family' => $family,
                'weights' => array_values(array_map(intval(...), $weights)),
                'subsets' => array_values(array_map(strval(...), $subsets)),
            ];
        }

        return $definitions;
    }

    /**
     * @return array<string, string>
     */
    public function cssFontVariables(): array
    {
        $variables = [];

        foreach ($this->fonts() as $key => $definition) {
            if (! is_array($definition)) {
                continue;
            }

            $family = (string) ($definition['family'] ?? '');

            if ($family === '') {
                continue;
            }

            $fallback = (string) ($definition['fallback'] ?? 'ui-sans-serif, system-ui, sans-serif');
            $variables[(string) $key] = "'{$family}', {$fallback}";
        }

        return $variables;
    }

    /**
     * @return array<string, array{text: string, leading: string}>
     */
    private function defaultScale(): array
    {
        return [
            'sm' => ['text' => 'text-sm', 'leading' => 'leading-5'],
            'default' => ['text' => 'text-base', 'leading' => 'leading-6'],
            'lg' => ['text' => 'text-lg', 'leading' => 'leading-7'],
            'xl' => ['text' => 'text-xl', 'leading' => 'leading-8'],
        ];
    }

    /**
     * @param  array<string, mixed>  $base
     * @param  array<string, mixed>  $override
     * @return array<string, mixed>
     */
    private function mergeTypography(array $base, array $override): array
    {
        $merged = array_replace_recursive($base, $override);

        if (isset($merged['scale']) && is_array($merged['scale'])) {
            $merged['scale'] = array_intersect_key($merged['scale'], array_flip(self::SCALE_KEYS));
        }

        return $merged;
    }
}
