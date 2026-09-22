<?php

use Tests\TestCase;

it('redirige la raiz al dashboard', function () {
    /** @var TestCase $this */
    $this->get('/')->assertRedirect('/dashboard');
});

it('manda a login a un invitado que va al dashboard', function () {
    /** @var TestCase $this */
    $this->get('/dashboard')->assertRedirect('/login');
});

it('expone el health check del contenedor', function () {
    /** @var TestCase $this */
    $this->get('/up')->assertOk();
});
