<?php

use App\Models\AccessRequest;
use App\Models\AuditLog;
use App\Models\Contact;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\UploadedFile;

function enableDemo(): void
{
    config(['demo.enabled' => true]);
}

test('demo mode is disabled by default and does not block administration', function () {
    expect(config('demo.enabled'))->toBeFalse();

    $this->actingAs(makeUser('admin'))
        ->post('/admin/settings', ['company_name' => 'Nouvelle Org'])
        ->assertSessionHasNoErrors();

    expect(Setting::where('key', 'company_name')->value('value'))->toBe('Nouvelle Org');
});

test('demo mode blocks sensitive administration actions', function (string $method, string $uri, array $data = []) {
    enableDemo();
    $admin = makeUser('admin');
    $target = makeUser('commercial');
    $uri = str_replace('{user}', (string) $target->id, $uri);

    $this->actingAs($admin)->from('/admin/dashboard')
        ->call($method, $uri, $data)
        ->assertRedirect('/admin/dashboard')
        ->assertSessionHasErrors('demo');

    expect(User::find($target->id))->not->toBeNull();
})->with([
    'paramètres' => ['POST', '/admin/settings', ['company_name' => 'Piratée']],
    'création de compte' => ['POST', '/admin/users', ['name' => 'X', 'email' => 'x@example.com', 'role' => 'admin', 'password' => 'Secret123!']],
    'suppression de compte' => ['DELETE', '/admin/users/{user}'],
    'réinitialisation de mot de passe' => ['POST', '/admin/users/{user}/reset-password'],
    'sauvegarde' => ['POST', '/admin/backup'],
    'export RGPD' => ['POST', '/admin/gdpr/export', ['user_id' => 1]],
    'maintenance' => ['DELETE', '/admin/maintenance/cleanup'],
    'export des comptes' => ['GET', '/admin/export'],
    'règle d\'attribution' => ['POST', '/admin/attribution-rules', ['name' => 'X', 'criteria_type' => 'source', 'criteria_value' => 'Web', 'priority' => 1]],
]);

test('demo mode blocks profile changes, public access requests and file uploads', function () {
    enableDemo();
    $commercial = makeUser('commercial', ['email' => 'commercial-demo@example.com']);

    $this->actingAs($commercial)->from('/profile')
        ->put('/profile', ['name' => 'Piraté', 'email' => 'pirate@example.com'])
        ->assertSessionHasErrors('demo');
    expect($commercial->fresh()->email)->toBe('commercial-demo@example.com');

    $this->actingAs($commercial)->from('/contacts/create')
        ->post('/contacts', ['nom' => 'Upload', 'photo' => UploadedFile::fake()->image('photo.jpg')])
        ->assertSessionHasErrors('demo');
    expect(Contact::where('nom', 'Upload')->exists())->toBeFalse();

    auth()->logout();
    $this->from('/request-access')
        ->post('/request-access', ['nom' => 'A', 'prenom' => 'B', 'email' => 'demande@example.com', 'role' => 'admin'])
        ->assertSessionHasErrors('demo');
    expect(AccessRequest::count())->toBe(0);
});

test('demo mode keeps the business features usable', function () {
    enableDemo();
    $admin = makeUser('admin');
    $commercial = makeUser('commercial');

    foreach (['/admin/dashboard', '/admin/users', '/admin/settings', '/admin/audit-logs', '/admin/maintenance'] as $page) {
        $this->actingAs($admin)->get($page)->assertOk();
    }

    $this->actingAs($commercial)->post('/contacts', ['nom' => 'Martin', 'prenom' => 'Léa', 'email' => 'lea.martin@example.com'])
        ->assertRedirect(route('contacts.index'));
    expect(Contact::where('email', 'lea.martin@example.com')->exists())->toBeTrue();

    $opportunity = makeOpportunity(makeContact($commercial));
    $this->actingAs($commercial)
        ->post("/opportunities/{$opportunity->id}/transition", ['stade' => 'proposition', 'besoin' => 'Démo'])
        ->assertRedirect();
    expect($opportunity->fresh()->stade)->toBe('proposition');

    $this->actingAs($commercial)->get('/reports/csv?type=opportunities')->assertOk();
});

test('demo mode shows the demo accounts on the login page only when enabled', function () {
    $this->get('/login')->assertDontSee('Démonstration — données fictives');

    enableDemo();
    $this->get('/login')->assertSee('Démonstration — données fictives')->assertSee('commercial@example.com');
});

test('demo mode stores no visitor IP address in the audit log', function () {
    enableDemo();
    $user = makeUser('commercial', ['password' => 'Secret@123']);

    $this->post('/login', ['email' => $user->email, 'password' => 'Secret@123']);

    $entries = AuditLog::where('action', 'login')->get();
    expect($entries)->not->toBeEmpty();
    $entries->each(function (AuditLog $entry) {
        expect($entry->ip_address)->toBeNull();
        expect($entry->user_agent)->toBeNull();
        expect($entry->new_values ?? [])->not->toHaveKey('ip');
    });
});

test('demo mode forces the log mailer', function () {
    config(['mail.default' => 'smtp']);
    enableDemo();

    (new App\Providers\AppServiceProvider(app()))->boot();

    expect(config('mail.default'))->toBe('log');
});

test('demo:reset refuses to run outside the demo or on a database not dedicated to it', function () {
    $existing = makeUser('admin');

    $this->artisan('demo:reset')->expectsOutputToContain('DEMO_MODE')->assertFailed();

    enableDemo();
    config(['demo.database_marker' => 'demo']); // la base de test « crm_portfolio_test » ne contient pas « demo »
    $this->artisan('demo:reset')->expectsOutputToContain('ne contient pas')->assertFailed();

    expect(User::find($existing->id))->not->toBeNull(); // aucune réinitialisation n'a eu lieu
});
