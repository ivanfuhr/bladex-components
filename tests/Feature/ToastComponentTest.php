<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a toast provider and toast message', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::toast.provider position="top-right">
            <x-ui::toast variant="success" title="Saved" description="Your changes were saved." />
        </x-ui::toast.provider>
    BLADE);

    expect($html)
        ->toContain('data-toast-provider')
        ->toContain('data-toast-dismiss-label')
        ->toContain('aria-live="polite"')
        ->toContain('aria-atomic="true"')
        ->toContain('data-toast')
        ->toContain('data-variant="success"')
        ->toContain('role="status"')
        ->toContain('Saved')
        ->toContain('Your changes were saved.')
        ->toContain('data-toast-close');
});

it('uses alert role for danger toast variants', function () {
    $html = Blade::render(<<<'BLADE'
        <x-ui::toast variant="danger" title="Failed" description="Could not save." />
    BLADE);

    expect($html)
        ->toContain('data-variant="danger"')
        ->toContain('role="alert"')
        ->toContain('aria-live="assertive"')
        ->not->toContain('role="status"');
});
