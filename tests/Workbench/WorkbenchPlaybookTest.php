<?php

declare(strict_types=1);
use Workbench\App\Playbook\PlaybookPreviewRenderer;
use Workbench\App\Playbook\PlaybookRegistry;

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
    $response->assertSee('Forms');
    $response->assertSee('Typography');
    $response->assertSee('Overlays');
    $response->assertSee('Feedback');
    $response->assertSee('Navigation');
    $response->assertSee('Display');
    $response->assertSee('Date & time');
});

it('groups every playbook component into a catalog category', function () {
    $registry = app(PlaybookRegistry::class);
    $groupedSlugs = collect($registry->grouped())
        ->flatMap(fn (array $category) => collect($category['playbooks'])->pluck('slug'))
        ->all();

    expect($groupedSlugs)
        ->toHaveCount(count($registry->all()))
        ->toEqualCanonicalizing(collect($registry->all())->pluck('slug')->all());
});

it('renders the event studio showcase scenario', function () {
    $response = $this->get('/playbook/showcase');

    $response->assertOk();
    $response->assertSee('Northwind Summit 2026');
    $response->assertSee('data-tabs', false);
    $response->assertSee('data-dialog', false);
    $response->assertSee('data-table', false);
    $response->assertSee('data-toast-provider', false);
    $response->assertSee('id="guests"', false);
    $response->assertSee('aria-labelledby="setup-progress-label"', false);
    $response->assertSee('aria-label="Event sidebar"', false);
    $response->assertSee('aria-busy="true"', false);
});

it('marks catalog as the active playbook surface on the index', function () {
    $response = $this->get('/playbook');

    $response->assertOk();
    $response->assertSee('aria-current="page"', false);
    $response->assertSee('>Catalog</a>', false);
});

it('bridges playground pages to media when a media view exists', function () {
    $response = $this->get('/playbook/button');

    $response->assertOk();
    $response->assertSee(route('playbook.media.show', 'button'), false);
    $response->assertSee('Media page');
});

it('loads a single widget runtime on playbook chrome pages', function () {
    $response = $this->get('/playbook/accordion');

    $response->assertOk();
    $html = $response->getContent();

    expect($html)
        ->toContain('id="playbook-canvas"')
        ->toContain('x-html="html"')
        ->toContain('playbookPreview(')
        ->and($html)->not->toContain('/stencil/stencil.js');
});

it('returns interactive accordion and collapsible markup from the preview endpoint', function (string $slug, string $marker) {
    $response = $this->postJson('/playbook/preview', [
        'component' => $slug,
        'state' => [],
    ]);

    $response->assertOk();
    expect($response->json('html'))->toContain($marker);
})->with([
    ['accordion', 'data-accordion-trigger'],
    ['collapsible', 'data-collapsible-trigger'],
]);

it('links sibling components within the same catalog category', function () {
    $response = $this->get('/playbook/input');

    $response->assertOk();
    $response->assertSee(route('playbook.show', 'toggle-group'), false);
    $response->assertSee(route('playbook.show', 'input-currency'), false);
    $response->assertSee('Previous');
    $response->assertSee('Next');
});

it('widens the live preview canvas for table demos', function () {
    $response = $this->get('/playbook/table');

    $response->assertOk();
    $response->assertSee('max-w-5xl', false);
    expect($response->getContent())->toContain('max-w-5xl')
        ->and($response->getContent())->not->toContain('w-full max-w-md');
});

it('resolves media slugs and siblings from the playbook registry', function () {
    $registry = app(PlaybookRegistry::class);

    expect($registry->mediaSlug('button'))->toBe('button')
        ->and($registry->mediaSlug('heading'))->toBe('typography')
        ->and($registry->mediaSlug('icon'))->toBe('icons')
        ->and($registry->mediaSlug('empty'))->toBe('empty')
        ->and($registry->mediaSlug('sidebar'))->toBe('sidebar')
        ->and($registry->siblings('input')['previous']?->slug)->toBe('toggle-group')
        ->and($registry->siblings('input')['next']?->slug)->toBe('input-currency')
        ->and($registry->get('table')->wide)->toBeTrue()
        ->and($registry->get('button')->wide)->toBeFalse();
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

it('renders playbook media pages for button and datetime components', function (string $slug) {
    $this->get('/playbook/media/'.$slug)->assertOk();
    $this->get('/playbook/media/'.$slug.'?dark=1')->assertOk();
})->with([
    'button',
    'button-group',
    'toggle',
    'toggle-group',
    'icons',
    'typography',
    'calendar',
    'date-picker',
    'time-picker',
    'datetime-picker',
    'color-picker',
    'dropdown-menu',
    'popover',
    'command',
    'empty',
    'sidebar',
    'stepper',
    'stat',
]);

it('redirects legacy buttons media slug to button', function () {
    $this->get('/playbook/media/buttons')->assertRedirect('/playbook/media/button');
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
    ['command', 'data-command'],
    ['popover', 'data-popover'],
    ['separator', 'data-separator'],
    ['skeleton', 'data-skeleton'],
    ['empty', 'data-empty'],
    ['sidebar', 'data-sidebar-provider'],
    ['tabs', 'data-tabs'],
    ['stepper', 'data-stepper'],
    ['tooltip', 'data-tooltip'],
    ['toast', 'data-toast-provider'],
    ['progress', 'data-progress'],
    ['alert', 'data-alert'],
    ['table', 'data-table'],
    ['stat', 'data-stat'],
    ['icons', 'data-icon'],
    ['pagination', 'data-pagination'],
]);

it('emits well-formed blade snippets for every playbook component', function () {
    $renderer = app(PlaybookPreviewRenderer::class);
    $registry = app(PlaybookRegistry::class);

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

it('playbook preview remount cleans portaled overlay orphans including dropdown menus', function () {
    $source = (string) file_get_contents(dirname(__DIR__, 2).'/workbench/resources/js/playbook-preview.js');

    expect($source)
        ->toContain('[data-select-portaled]')
        ->toContain('[data-combobox-portaled]')
        ->toContain('[data-color-picker-portaled]')
        ->toContain('[data-dropdown-menu-portaled]');
});
