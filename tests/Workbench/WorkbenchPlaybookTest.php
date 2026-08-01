<?php

declare(strict_types=1);

it('lists playbook components on the index', function () {
    $response = $this->get('/playbook');

    $response->assertOk();
    $response->assertSee('Button');
    $response->assertSee('Input');
    $response->assertSee('Field');
    $response->assertSee('Textarea');
    $response->assertSee('Text');
    $response->assertSee('Heading');
    $response->assertSee('Accordion');
    $response->assertSee('Tabs');
    $response->assertSee('Tooltip');
    $response->assertSee('Alert');
    $response->assertSee('Table');
    $response->assertSee('Icons');
    $response->assertSee('Date Picker');
    $response->assertSee('Time Picker');
    $response->assertSee('Datetime Picker');
    $response->assertSee('Calendar');
    $response->assertSee('Event Studio showcase');
});

it('renders the event studio showcase scenario', function () {
    $response = $this->get('/playbook/showcase');

    $response->assertOk();
    $response->assertSee('Northwind Summit 2026');
    $response->assertSee('data-tabs', false);
    $response->assertSee('data-dialog', false);
    $response->assertSee('data-table', false);
    $response->assertSee('data-toast-provider', false);
});

it('renders the button playbook page with an initial preview', function () {
    $response = $this->get('/playbook/button');

    $response->assertOk();
    $response->assertSee('data-button', false);
});

it('renders the input-currency playbook page with an initial preview', function () {
    if (! extension_loaded('intl')) {
        $this->markTestSkipped('The intl extension is required for Number::currency.');
    }

    $response = $this->get('/playbook/input-currency');

    $response->assertOk();
    $response->assertSee('data-input-currency', false);
    $response->assertSee('R$', false);
});

it('renders the combobox playbook page with an initial preview', function () {
    $response = $this->get('/playbook/combobox');

    $response->assertOk();
    $response->assertSee('data-combobox', false);
    $response->assertSee('Search frameworks', false);
});

it('renders the file-upload playbook page with an initial preview', function () {
    $response = $this->get('/playbook/file-upload');

    $response->assertOk();
    $response->assertSee('data-file-upload', false);
    $response->assertSee('data-file-upload-dropzone', false);
});

it('renders the input-otp playbook page with an initial preview', function () {
    $response = $this->get('/playbook/input-otp');

    $response->assertOk();
    $response->assertSee('data-input-otp', false);
    $response->assertSee('data-input-otp-slot', false);
});

it('renders the slider playbook page with an initial preview', function () {
    $response = $this->get('/playbook/slider');

    $response->assertOk();
    $response->assertSee('data-slider', false);
    $response->assertSee('data-slider-thumb', false);
});

it('renders the calendar playbook page with an initial preview', function () {
    $response = $this->get('/playbook/calendar');

    $response->assertOk();
    $response->assertSee('data-calendar', false);
});

it('renders the date-picker playbook page with an initial preview', function () {
    $response = $this->get('/playbook/date-picker');

    $response->assertOk();
    $response->assertSee('data-date-picker', false);
});

it('renders the time-picker playbook page with an initial preview', function () {
    $response = $this->get('/playbook/time-picker');

    $response->assertOk();
    $response->assertSee('data-time-picker', false);
});

it('renders the datetime-picker playbook page with an initial preview', function () {
    $response = $this->get('/playbook/datetime-picker');

    $response->assertOk();
    $response->assertSee('data-datetime-picker', false);
});

it('returns preview html for a primary button variant', function () {
    $response = $this->postJson('/playbook/preview', [
        'component' => 'button',
        'state' => [
            'variant' => 'primary',
        ],
    ]);

    $response->assertOk();
    $response->assertJsonStructure(['html']);
    expect($response->json('html'))->toContain('bg-zinc-900');
});

it('returns not found for an unknown playbook component', function () {
    $this->get('/playbook/unknown')->assertNotFound();

    $this->postJson('/playbook/preview', [
        'component' => 'unknown',
        'state' => [],
    ])->assertNotFound();
});

it('rejects invalid preview state', function () {
    $response = $this->postJson('/playbook/preview', [
        'component' => 'button',
        'state' => [
            'variant' => 'not-a-real-variant',
        ],
    ]);

    $response->assertUnprocessable();
});

it('redirects the root url to the playbook index', function () {
    $this->get('/')->assertRedirect('/playbook');
});

it('renders layout and feedback playbook pages with initial previews', function (string $slug, string $marker) {
    $response = $this->get('/playbook/'.$slug);

    $response->assertOk();
    $response->assertSee($marker, false);
})->with([
    ['accordion', 'data-accordion'],
    ['collapsible', 'data-collapsible'],
    ['avatar', 'data-avatar'],
    ['badge', 'data-badge'],
    ['breadcrumb', 'data-breadcrumb'],
    ['card', 'data-card'],
    ['dropdown-menu', 'data-dropdown-menu'],
    ['separator', 'data-separator'],
    ['skeleton', 'data-skeleton'],
    ['tabs', 'data-tabs'],
    ['tooltip', 'data-tooltip'],
    ['toast', 'data-toast-provider'],
    ['progress', 'data-progress'],
    ['alert', 'data-alert'],
    ['table', 'data-table'],
    ['icons', 'data-icon'],
    ['pagination', 'data-pagination'],
]);

it('emits well-formed blade snippets for every playbook component', function () {
    $renderer = app(\Workbench\App\Playbook\PlaybookPreviewRenderer::class);
    $registry = app(\Workbench\App\Playbook\PlaybookRegistry::class);

    foreach ($registry->all() as $playbook) {
        $snippet = $renderer->renderSnippet($playbook->slug);

        if ($snippet === '') {
            continue;
        }

        expect($snippet)
            ->not->toContain('<<')
            ->not->toContain('>>')
            ->not->toMatch('/<[a-z][^>]*>\s*\/>/');
    }
});
