<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a shortcut scroll area with viewport and vertical scrollbar', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::scroll-area class="h-72" aria-label="Tags">
            <div>Alpha</div>
            <div>Bravo</div>
        </x-ui::scroll-area>
    BLADE);

    expect($html)
        ->toContain('data-scroll-area')
        ->toContain('data-scroll-area-type="hover"')
        ->toContain('data-scroll-area-hide-delay="600"')
        ->toContain('data-scroll-area-viewport')
        ->toContain('data-scroll-area-content')
        ->toContain('data-scroll-area-scrollbar')
        ->toContain('data-orientation="vertical"')
        ->toContain('data-scroll-area-thumb')
        ->toContain('tabindex="0"')
        ->toContain('aria-hidden="true"')
        ->toContain('aria-label="Tags"')
        ->toContain('Alpha')
        ->toContain('Bravo')
        ->not->toContain('data-orientation="horizontal"')
        ->not->toContain('data-scroll-area-corner');
});

it('renders horizontal scrollbar and corner in shortcut mode', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::scroll-area class="h-48 w-64" horizontal>
            Wide content
        </x-ui::scroll-area>
    BLADE);

    expect($html)
        ->toContain('data-orientation="vertical"')
        ->toContain('data-orientation="horizontal"')
        ->toContain('data-scroll-area-corner')
        ->toContain('Wide content');
});

it('supports type and scroll hide delay props', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::scroll-area type="always" :scroll-hide-delay="200">
            Always visible chrome
        </x-ui::scroll-area>
    BLADE);

    expect($html)
        ->toContain('data-scroll-area-type="always"')
        ->toContain('data-scroll-area-hide-delay="200"')
        ->toContain('Always visible chrome');
});

it('falls back to hover for unknown type values', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::scroll-area type="bogus">
            Content
        </x-ui::scroll-area>
    BLADE);

    expect($html)->toContain('data-scroll-area-type="hover"');
});

it('supports full composition without shortcut', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::scroll-area class="h-72" :shortcut="false">
            <x-ui::scroll-area.viewport>
                Custom body
            </x-ui::scroll-area.viewport>
            <x-ui::scroll-area.scrollbar orientation="vertical" />
            <x-ui::scroll-area.scrollbar orientation="horizontal" />
            <x-ui::scroll-area.corner />
        </x-ui::scroll-area>
    BLADE);

    expect($html)
        ->toContain('data-scroll-area-viewport')
        ->toContain('Custom body')
        ->toContain('data-orientation="vertical"')
        ->toContain('data-orientation="horizontal"')
        ->toContain('data-scroll-area-corner')
        ->toContain('data-scroll-area-thumb');
});

it('allows custom thumb inside scrollbar slot', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::scroll-area :shortcut="false">
            <x-ui::scroll-area.viewport>Body</x-ui::scroll-area.viewport>
            <x-ui::scroll-area.scrollbar>
                <x-ui::scroll-area.thumb class="bg-red-500" />
            </x-ui::scroll-area.scrollbar>
        </x-ui::scroll-area>
    BLADE);

    expect($html)
        ->toContain('data-scroll-area-thumb')
        ->toContain('bg-red-500')
        ->toContain('Body');
});

it('scroll area script uses lifecycle teardown and mount hooks', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/scroll-area.js');

    expect($source)
        ->toContain("import { createBindSignal } from './shared/lifecycle.js'")
        ->toContain('createBindSignal(')
        ->toContain('{ signal }')
        ->toContain('stencil:mount')
        ->toContain('export function initScrollAreas')
        ->toContain('ResizeObserver')
        ->toContain('data-scroll-area-thumb')
        ->toContain('HTMLTextAreaElement');
});
