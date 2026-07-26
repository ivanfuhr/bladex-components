<?php

declare(strict_types=1);

use Workbench\App\Playbook\PlaybookCode;

it('emits paste-safe html attributes for strings with spaces', function () {
    expect(PlaybookCode::attribute('placeholder', 'Choose industry…'))
        ->toBe('placeholder="Choose industry…"');

    expect(PlaybookCode::attribute('class', 'max-w-md w-full'))
        ->toBe('class="max-w-md w-full"');
});

it('emits paste-safe bound attributes for dynamic snippet values', function () {
    expect(PlaybookCode::bound('prefix', 'https://'))
        ->toBe(':prefix="\'https://\'"');
});

it('returns a valid select playbook snippet', function () {
    $response = $this->postJson('/playbook/preview', [
        'component' => 'select',
        'state' => [],
    ]);

    $response->assertOk();

    $snippet = (string) $response->json('snippet');

    expect($snippet)
        ->toContain('placeholder="Choose industry…"')
        ->toContain('class="max-w-md w-full"')
        ->not->toContain(":placeholder='Choose");
});
