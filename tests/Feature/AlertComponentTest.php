<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('uses status role and polite live region for info alerts', function () {
    $html = Blade::render('<x-std::alert variant="info" title="Tip">Note</x-std::alert>');

    expect($html)
        ->toContain('role="status"')
        ->toContain('aria-live="polite"')
        ->toContain('aria-atomic="true"')
        ->not->toContain('role="alert"');
});

it('uses alert role and assertive live region for danger alerts', function () {
    $html = Blade::render('<x-std::alert variant="danger" title="Failed">Error</x-std::alert>');

    expect($html)
        ->toContain('role="alert"')
        ->toContain('aria-live="assertive"')
        ->toContain('aria-atomic="true"')
        ->toContain('data-alert-icon');
});

it('renders default variant icons when enabled', function () {
    $html = Blade::render('<x-std::alert variant="success" title="Saved">Done</x-std::alert>');

    expect($html)
        ->toContain('data-alert-icon')
        ->toContain('data-icon')
        ->toContain('M20 6 9 17l-5-5');
});
