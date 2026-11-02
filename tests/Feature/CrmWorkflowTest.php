<?php

use App\Models\AccessRequest;
use App\Models\Contact;
use App\Models\Opportunity;
use App\Models\User;

test('an admin creates a contact', function () {
    $this->actingAs(makeUser('admin'))->post('/contacts', [
        'nom' => 'Lambert',
        'prenom' => 'Thomas',
        'email' => 'Thomas.Lambert@example.com',
        'entreprise' => 'Nexa Logistique',
        'source' => 'Site Web',
    ])->assertRedirect(route('contacts.index'));

    // Le mutateur normalise l'e-mail en minuscules
    expect(Contact::where('email', 'thomas.lambert@example.com')->exists())->toBeTrue();
});

test('activities and tasks created from the contact page are shown on it', function () {
    $admin = makeUser('admin');
    $contact = makeContact($admin);

    // Les formulaires de la fiche contact envoient le nom de classe complet
    $this->actingAs($admin)->post('/activities', [
        'type' => 'appel', 'description' => 'Appel de découverte', 'date_activite' => now()->toDateTimeString(),
        'parent_type' => 'App\Models\Contact', 'parent_id' => $contact->id,
    ])->assertRedirect();

    $this->actingAs($admin)->post('/tasks', [
        'titre' => 'Envoyer le devis', 'assigned_to' => $admin->id, 'due_date' => now()->addDay()->toDateTimeString(),
        'priority' => 'high', 'related_type' => 'App\Models\Contact', 'related_id' => $contact->id,
    ])->assertRedirect();

    expect($contact->activities()->count())->toBe(1);
    expect($contact->tasks()->count())->toBe(1);

    $this->actingAs($admin)->get("/contacts/{$contact->id}")
        ->assertOk()
        ->assertSee('Appel de découverte')
        ->assertSee('Envoyer le devis');
});

test('activities cannot target an arbitrary model', function () {
    $admin = makeUser('admin');

    $this->actingAs($admin)->post('/activities', [
        'type' => 'note', 'description' => 'x', 'date_activite' => now()->toDateTimeString(),
        'parent_type' => 'App\Models\User', 'parent_id' => $admin->id,
    ])->assertSessionHasErrors('parent_type');
});

test('the opportunity form lists contacts whose names contain accents', function () {
    $admin = makeUser('admin');
    makeContact($admin, ['prenom' => 'Élise', 'nom' => 'Durand']);

    $this->actingAs($admin)->get('/opportunities/create')
        ->assertOk()
        ->assertSee('&quot;initials&quot;:&quot;' . trim(json_encode('ÉD'), '"') . '&quot;', false);
});

test('a commercial creates an opportunity assigned to himself', function () {
    $commercial = makeUser('commercial');
    $contact = makeContact($commercial);

    $this->actingAs($commercial)->post('/opportunities', [
        'titre' => 'Logiciel de suivi de flotte',
        'contact_id' => $contact->id,
        'montant_estime' => 42000,
        'stade' => 'prospection',
        'probabilite' => 10,
        'commercial_id' => makeUser('commercial')->id, // ignoré : seul un admin peut choisir
    ])->assertRedirect(route('opportunities.index'));

    $opportunity = Opportunity::where('titre', 'Logiciel de suivi de flotte')->firstOrFail();
    expect($opportunity->commercial_id)->toBe($commercial->id);
    expect($opportunity->attributionHistory()->count())->toBe(1);
});

test('a stage transition records the qualification data, the history and syncs the contact status', function () {
    $commercial = makeUser('commercial');
    $contact = makeContact($commercial);
    $opportunity = makeOpportunity($contact, ['stade' => 'qualification']);

    $this->actingAs($commercial)
        ->post("/opportunities/{$opportunity->id}/transition", ['stade' => 'proposition', 'besoin' => 'Refonte du SI financier'])
        ->assertRedirect();

    $opportunity->refresh();
    expect($opportunity->stade)->toBe('proposition');
    expect($opportunity->besoin)->toBe('Refonte du SI financier');
    expect($opportunity->history()->where('new_stage', 'proposition')->exists())->toBeTrue();
    expect($contact->fresh()->statut)->toBe('proposition');
});

test('winning an opportunity turns the contact into a client', function () {
    $commercial = makeUser('commercial');
    $contact = makeContact($commercial);
    $opportunity = makeOpportunity($contact, ['stade' => 'negociation']);

    $this->actingAs($commercial)->post("/opportunities/{$opportunity->id}/mark-won")->assertRedirect();

    expect($opportunity->fresh()->stade)->toBe('gagne');
    expect($contact->fresh()->statut)->toBe('client');
});

test('the commercial quota widget shows the won amount used for its percentage', function () {
    $commercial = makeUser('commercial');
    $contact = makeContact($commercial);
    makeOpportunity($contact, ['stade' => 'gagne', 'montant_estime' => 10000]);
    makeOpportunity($contact, ['stade' => 'negociation', 'montant_estime' => 50000]);

    $data = $this->actingAs($commercial)->getJson('/commercial/dashboard')->json('kpis');

    expect((float) $data['goal_actual'])->toBe(10000.0);
    expect($data['goal_percentage'])->toEqual(20); // 10 000 / quota de 50 000
    expect((float) $data['my_forecast_revenue'])->toBe(50000.0);

    $this->actingAs($commercial)->get('/commercial/dashboard')->assertSee(format_currency(10000) . ' réalisé');
});

test('durations computed with Carbon 3 are positive whole days', function () {
    $opportunity = makeOpportunity(makeContact(makeUser('commercial')));
    $opportunity->forceFill(['created_at' => now()->subDays(4)])->saveQuietly();

    expect($opportunity->fresh()->time_in_stage)->toBe(4);

    $task = App\Models\Task::create([
        'titre' => 'Relancer le client', 'assigned_to' => makeUser('commercial')->id, 'created_by' => makeUser('admin')->id,
        'due_date' => now()->subDays(3), 'statut' => 'todo', 'priority' => 'high',
    ]);

    expect((new App\Notifications\TaskOverdueNotification($task))->toArray($task->assignee)['days_overdue'])->toBe(3);
});

test('support creates a ticket and answers it', function () {
    $support = makeUser('support');
    $contact = makeContact(makeUser('commercial'));

    $this->actingAs($support)->post('/tickets', [
        'subject' => 'Accès utilisateur bloqué', 'description' => 'Impossible de se connecter',
        'category' => 'technical', 'priority' => 'high', 'contact_id' => $contact->id,
    ])->assertRedirect();

    $ticket = $contact->tickets()->firstOrFail();
    expect($ticket->status)->toBe('new');

    $this->actingAs($support)->post("/tickets/{$ticket->id}/response", ['message' => 'Compte débloqué'])->assertRedirect();
    $this->actingAs($support)->put("/tickets/{$ticket->id}", ['status' => 'resolved'])->assertRedirect();

    expect($ticket->fresh()->status)->toBe('resolved');
    expect($ticket->activities()->where('contenu', 'Compte débloqué')->exists())->toBeTrue();
    $this->actingAs($support)->get('/support/tickets')->assertOk();
});

test('an admin approves an access request, which creates the account', function () {
    $request = AccessRequest::create([
        'nom' => 'Lemoine', 'prenom' => 'Arthur', 'email' => 'arthur.lemoine@example.com', 'role' => 'commercial', 'status' => 'pending',
    ]);

    $this->actingAs(makeUser('admin'))->post("/admin/access-requests/{$request->id}/approve")->assertRedirect();

    expect($request->fresh()->status)->toBe('approved');
    expect(User::where('email', 'arthur.lemoine@example.com')->value('role'))->toBe('commercial');
});

test('the maintenance cleanup no longer fails', function () {
    $this->actingAs(makeUser('admin'))
        ->delete('/admin/maintenance/cleanup')
        ->assertRedirect()
        ->assertSessionHas('success');
});

test('CSV exports only contain the commercial own opportunities', function () {
    $hugo = makeUser('commercial');
    makeOpportunity(makeContact($hugo), ['titre' => 'Affaire de Hugo']);
    makeOpportunity(makeContact(makeUser('commercial')), ['titre' => 'Affaire d\'Inès']);

    $response = $this->actingAs($hugo)->get('/reports/csv?type=opportunities');
    $response->assertOk();
    expect($response->headers->get('Content-Type'))->toContain('text/csv');

    $csv = $response->streamedContent();
    expect($csv)->toContain('Affaire de Hugo')->not->toContain('Affaire d\'Inès');
});
