<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('uses status role and polite live region for info alerts', function () {
    $html = Blade::render('<x-ui::alert variant="info" title="Tip">Note</x-ui::alert>');

    expect($html)
        ->toContain('role="status"')
        ->toContain('aria-live="polite"')
        ->toContain('aria-atomic="true"')
        ->not->toContain('role="alert"');
});

it('uses alert role and assertive live region for danger alerts', function () {
    $html = Blade::render('<x-ui::alert variant="danger" title="Failed">Error</x-ui::alert>');

    expect($html)
        ->toContain('role="alert"')
        ->toContain('aria-live="assertive"')
        ->toContain('aria-atomic="true"');
});
