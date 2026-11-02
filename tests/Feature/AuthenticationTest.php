<?php

test('public pages are reachable', function () {
    $this->get('/')->assertOk();
    $this->get('/login')->assertOk();
    $this->get('/request-access')->assertOk();
});

test('guests are redirected to the login page', function () {
    $this->get('/contacts')->assertRedirect('/login');
    $this->get('/admin/dashboard')->assertRedirect('/login');
});

test('users are redirected to the dashboard of their role after login', function (string $role, string $route) {
    $user = makeUser($role, ['password' => 'Secret@123']);

    $this->post('/login', ['email' => $user->email, 'password' => 'Secret@123'])
        ->assertRedirect(route($route));

    $this->assertAuthenticatedAs($user);
})->with([
    ['admin', 'admin.dashboard'],
    ['commercial', 'commercial.dashboard'],
    ['support', 'support.dashboard'],
    ['visitor', 'dashboard'],
]);

test('login fails with a wrong password', function () {
    $user = makeUser('admin', ['password' => 'Secret@123']);

    $this->from('/login')->post('/login', ['email' => $user->email, 'password' => 'mauvais-mdp'])
        ->assertRedirect('/login')
        ->assertSessionHasErrors('email');

    $this->assertGuest();
});

test('logout ends the session', function () {
    $this->actingAs(makeUser('commercial'))->post('/logout')->assertRedirect(route('home'));
    $this->assertGuest();
});

test('debug and diagnostic endpoints are not exposed', function (string $path) {
    $this->actingAs(makeUser('admin'))->get($path)->assertNotFound();
})->with(['/test-public', '/debug-routing-simple', '/debug-routing-controller', '/fix-encoding']);
