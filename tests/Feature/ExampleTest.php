<?php

use App\Models\User;

it('redirects guests to the login screen', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('login'));
});

it('returns a successful response for authenticated users', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/');

    $response->assertOk();
});
