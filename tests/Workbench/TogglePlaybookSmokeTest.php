<?php

declare(strict_types=1);

it('renders toggle, toggle-group, and button-group playbook pages', function () {
    $this->get('/playbook/toggle')->assertOk()->assertSee('data-toggle', false);
    $this->get('/playbook/toggle-group')->assertOk()->assertSee('data-toggle-group', false);
    $this->get('/playbook/button-group')->assertOk()->assertSee('data-button-group', false);
});
