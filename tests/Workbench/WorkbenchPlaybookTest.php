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
