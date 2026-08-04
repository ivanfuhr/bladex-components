<?php

declare(strict_types=1);

namespace Workbench\App\Playbook;

use Illuminate\Support\Str;
use Ivanfuhr\Stencil\Support\Code\CodeHighlighter;

final class PlaybookGuide
{
    private const string DOCS_ROOT = __DIR__.'/../../resources/docs/components';

    public function exists(string $slug): bool
    {
        return is_file($this->path($slug));
    }

    public function html(string $slug): ?string
    {
        $path = $this->path($slug);

        if (! is_file($path)) {
            return null;
        }

        $markdown = (string) file_get_contents($path);

        if (trim($markdown) === '') {
            return null;
        }

        $html = Str::markdown($markdown, [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        return (new CodeHighlighter)->highlightHtmlDocument($html);
    }

    /**
     * @return list<string>
     */
    public function slugs(): array
    {
        if (! is_dir(self::DOCS_ROOT)) {
            return [];
        }

        $slugs = [];

        foreach (glob(self::DOCS_ROOT.'/*.md') ?: [] as $path) {
            $slugs[] = basename($path, '.md');
        }

        sort($slugs);

        return $slugs;
    }

    private function path(string $slug): string
    {
        return self::DOCS_ROOT.'/'.$slug.'.md';
    }
}
