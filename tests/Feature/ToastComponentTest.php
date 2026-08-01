<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;

it('renders a toast provider and toast message', function () {
    $html = Blade::render(<<<'BLADE'
        <x-stencil::toast.provider position="top-right">
            <x-stencil::toast variant="success" title="Saved" description="Your changes were saved." />
        </x-stencil::toast.provider>
    BLADE);

    expect($html)
        ->toContain('data-toast-provider')
        ->toContain('aria-live="polite"')
        ->toContain('data-toast')
        ->toContain('data-variant="success"')
        ->toContain('Saved')
        ->toContain('Your changes were saved.')
        ->toContain('data-toast-close');
});
