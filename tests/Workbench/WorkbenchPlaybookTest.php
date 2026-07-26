<?php

declare(strict_types=1);

it('lists playbook components on the index', function () {
    $response = $this->get('/playbook');

    $response->assertOk();
    $response->assertSee('Button');
    $response->assertSee('Input');
    $response->assertSee('Text');
    $response->assertSee('Heading');
});

it('renders the button playbook page with an initial preview', function () {
    $response = $this->get('/playbook/button');

    $response->assertOk();
    $response->assertSee('data-button', false);
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
