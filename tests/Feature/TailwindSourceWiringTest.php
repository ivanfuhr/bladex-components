<?php

declare(strict_types=1);

use Ivanfuhr\StdComponents\Support\Form\FormControlClassMap;
use Ivanfuhr\StdComponents\Support\Tailwind\ComponentClassSources;

it('keeps cascade layer lock, dialog safety net, and Support scan wiring', function () {
    $tailwind = (string) file_get_contents(dirname(__DIR__, 2).'/resources/tailwind/std-components.css');
    $package = (string) file_get_contents(dirname(__DIR__, 2).'/resources/css/std-components.css');
    $workbench = (string) file_get_contents(dirname(__DIR__, 2).'/workbench/resources/css/std-components.css');

    foreach ([$tailwind, $package] as $css) {
        expect($css)
            ->toContain('@layer theme, base, components, utilities;')
            ->toContain('src/Support/**/*.php')
            ->toContain('src/View/Components/Dialog/Content.php')
            ->toContain('src/View/Components/Command/Dialog.php')
            ->toContain('@source inline("open:opacity-100 open:motion-safe:scale-100")')
            ->toContain('.dialog__content:is(:open, [open])')
            ->toContain('opacity: 1')
            ->not->toContain('src/View/Components/**/*.php');
    }

    expect($workbench)
        ->toContain('src/Support/**/*.php')
        ->toContain('src/View/Components/Dialog/Content.php')
        ->toContain('src/View/Components/Command/Dialog.php')
        ->not->toContain('src/View/Components/**/*.php');
});

it('scans checkbox checked fill utilities via Support class maps', function () {
    $formControl = (string) file_get_contents(dirname(__DIR__, 2).'/src/Support/Form/FormControlClassMap.php');
    $sources = ComponentClassSources::CLASSES;

    expect($formControl)
        ->toContain('checked:bg-zinc-900')
        ->toContain('checked:border-zinc-900')
        ->toContain('dark:checked:bg-zinc-50')
        ->toContain('dark:checked:border-zinc-50');

    expect(app(FormControlClassMap::class)->checkboxControlClasses())
        ->toContain('checked:bg-zinc-900')
        ->toContain('checked:border-zinc-900');

    expect($sources)->toContain('checked:bg-zinc-900');
});

it('covers View/Components PHP utility tokens through Support scan surfaces', function () {
    $root = dirname(__DIR__, 2);
    $supportText = collect(new RecursiveIteratorIterator(new RecursiveDirectoryIterator(
        $root.'/src/Support',
        FilesystemIterator::SKIP_DOTS,
    )))
        ->filter(fn (SplFileInfo $file): bool => $file->isFile() && $file->getExtension() === 'php')
        ->map(fn (SplFileInfo $file): string => (string) file_get_contents($file->getPathname()))
        ->implode("\n");

    $componentFiles = collect(new RecursiveIteratorIterator(new RecursiveDirectoryIterator(
        $root.'/src/View/Components',
        FilesystemIterator::SKIP_DOTS,
    )))
        ->filter(fn (SplFileInfo $file): bool => $file->isFile() && $file->getExtension() === 'php');

    $missing = [];

    foreach ($componentFiles as $file) {
        $src = (string) file_get_contents($file->getPathname());
        preg_match_all("/'([^'\\\\]*(?:\\\\.[^'\\\\]*)*)'|\"([^\"\\\\]*(?:\\\\.[^\"\\\\]*)*)\"/", $src, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $blob = stripcslashes($match[1] !== '' ? $match[1] : ($match[2] ?? ''));

            if ($blob === '' || strlen($blob) > 600) {
                continue;
            }

            if (! preg_match('/(checked:bg-|checked:border-|data-\[state=on\]:bg-|dark:checked:|bg-violet-600|bg-lime-500|bg-rose-600|open:opacity-100)/', $blob)) {
                continue;
            }

            foreach (preg_split('/\s+/', $blob) ?: [] as $token) {
                if ($token === '' || ! preg_match('/(checked:|data-\[state=on\]:|bg-violet-|bg-lime-|bg-rose-|open:opacity)/', $token)) {
                    continue;
                }

                if (! str_contains($supportText, $token) && ! str_contains($supportText, $blob)) {
                    $missing[] = $file->getFilename().': '.$token;
                }
            }
        }
    }

    expect($missing)->toBeEmpty();
});
