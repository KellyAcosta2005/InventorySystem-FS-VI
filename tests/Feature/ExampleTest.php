<?php

use Tests\TestCase;

test('the public home redirects to the dashboard', function () {
    /** @var TestCase $this */
    $response = $this->get('/');

    $response->assertRedirect('/dashboard');
});
