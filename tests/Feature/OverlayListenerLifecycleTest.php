<?php

declare(strict_types=1);

it('shared lifecycle util aborts bind signals on disconnect and rebind', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/shared/lifecycle.js');

    expect($source)
        ->toContain('export function createBindSignal')
        ->toContain('AbortController')
        ->toContain('controllers.get(root)?.abort()')
        ->toContain('!root.isConnected')
        ->toContain('MutationObserver');
});

it('overlay widgets tear down document listeners with createBindSignal', function (string $relativePath) {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/'.$relativePath);

    expect($source)
        ->toContain("import { createBindSignal } from './shared/lifecycle.js'")
        ->toContain('createBindSignal(')
        ->toContain('{ signal }')
        ->toContain('std:mount');
})->with([
    'popover' => ['popover.js'],
    'sidebar' => ['sidebar.js'],
    'select' => ['select.js'],
    'combobox' => ['combobox.js'],
    'dropdown-menu' => ['dropdown-menu.js'],
    'color-picker' => ['color-picker.js'],
    'time-picker' => ['time-picker.js'],
    'datetime-picker' => ['datetime-picker.js'],
    'date-picker' => ['date-picker.js'],
    'command' => ['command.js'],
    'scroll-area' => ['scroll-area.js'],
]);

it('sidebar matchMedia listener uses abort signal', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/sidebar.js');

    expect($source)
        ->toContain("media.addEventListener('change', onMediaChange, { signal })")
        ->toContain('document.addEventListener(\'keydown\', onKeydown, { signal })');
});

it('anchored panel dismiss helper accepts an abort signal', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/shared/anchored-panel.js');

    expect($source)
        ->toContain('export function bindPopoverDismiss')
        ->toContain('@param {AbortSignal} [signal]')
        ->toContain('signal ? { signal } : {}')
        ->not->toContain("addEventListener(\n        'scroll'");
});

it('shared scroll lock helper is reference-counted and allowlists overlay panels', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/shared/scroll-lock.js');

    expect($source)
        ->toContain('export function acquireBodyScrollLock')
        ->toContain("document.addEventListener('wheel', onScrollAttempt")
        ->toContain("document.addEventListener('touchmove', onScrollAttempt")
        ->toContain("window.addEventListener('scroll', onWindowScroll")
        ->toContain('options.signal?.addEventListener')
        ->toContain('[data-scroll-area-viewport]')
        ->toContain('syncNestedScrollAreas')
        ->toContain("container.dataset.stdScrollLocked = 'true'")
        ->toContain('onLockedContainerScroll')
        ->toContain('onLockedContainerWheel')
        ->not->toContain("document.body.style.position = 'fixed'")
        ->not->toContain("document.body.style.overflow = 'hidden'")
        ->not->toContain("document.documentElement.style.overflow = 'hidden'");
});

it('floating overlays acquire body scroll lock while open', function (string $relativePath) {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/resources/assets/js/'.$relativePath);

    expect($source)
        ->toContain("import { acquireBodyScrollLock } from './shared/scroll-lock.js'")
        ->toContain('acquireBodyScrollLock(')
        ->toContain('releaseScrollLock');
})->with([
    'popover' => ['popover.js'],
    'select' => ['select.js'],
    'combobox' => ['combobox.js'],
    'dropdown-menu' => ['dropdown-menu.js'],
    'color-picker' => ['color-picker.js'],
    'time-picker' => ['time-picker.js'],
    'datetime-picker' => ['datetime-picker.js'],
    'date-picker' => ['date-picker.js'],
]);
