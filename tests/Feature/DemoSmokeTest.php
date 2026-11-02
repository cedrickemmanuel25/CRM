<?php

use App\Models\User;
use Database\Seeders\DemoSeeder;

beforeEach(function () {
    $this->seed(DemoSeeder::class);
});

test('the demo seeder creates a representative data set', function () {
    expect(User::count())->toBe(6);
    expect(App\Models\Contact::count())->toBeGreaterThan(20);
    expect(App\Models\Opportunity::count())->toBe(20);
    expect(App\Models\Task::count())->toBeGreaterThan(10);
    expect(App\Models\Ticket::count())->toBe(7);
});

test('every main screen renders without server error', function (string $email, array $paths) {
    $user = User::where('email', $email)->firstOrFail();
    $ids = [
        '{contact}' => App\Models\Contact::min('id'),
        '{opportunity}' => App\Models\Opportunity::min('id'),
        '{task}' => App\Models\Task::min('id'),
        '{ticket}' => App\Models\Ticket::min('id'),
    ];

    foreach ($paths as $path) {
        $path = strtr($path, $ids);
        $status = $this->actingAs($user)->get($path)->status();
        expect($status)->toBe(200, "{$email} {$path} a renvoyé {$status}");
    }
})->with([
    'admin' => ['admin@example.com', [
        '/admin/dashboard', '/contacts', '/contacts/{contact}', '/contacts/create', '/contacts/{contact}/edit',
        '/opportunities', '/opportunities?view=list', '/opportunities/{opportunity}', '/opportunities/create', '/opportunities/{opportunity}/edit',
        '/calendar', '/tasks/{task}', '/tasks/create', '/tickets', '/tickets/{ticket}', '/tickets/create', '/activities',
        '/reports', '/reports/print', '/notifications', '/profile/notifications', '/admin/profile',
        '/admin/users', '/admin/settings', '/admin/audit-logs', '/admin/attribution-rules', '/admin/maintenance', '/admin/access-requests',
    ]],
    'commercial' => ['commercial@example.com', [
        '/commercial/dashboard', '/contacts', '/opportunities', '/opportunities/create', '/calendar', '/reports', '/profile',
    ]],
    'support' => ['support@example.com', [
        '/support/dashboard', '/support/tickets', '/support/reports', '/tickets', '/tickets/{ticket}', '/contacts', '/calendar',
    ]],
    'visitor' => ['visiteur@example.com', [
        '/dashboard', '/contacts', '/opportunities', '/calendar', '/reports',
    ]],
]);

test('PDF exports are generated', function (string $email, string $path) {
    $response = $this->actingAs(User::where('email', $email)->firstOrFail())->get($path);

    $response->assertOk();
    expect($response->headers->get('Content-Type'))->toBe('application/pdf');
})->with([
    ['admin@example.com', '/reports/pdf?type=opportunities'],
    ['admin@example.com', '/reports/pdf?type=leads'],
    ['support@example.com', '/support/reports/pdf?period=month'],
]);
