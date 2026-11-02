<?php

test('only admins reach the administration area', function (string $role) {
    $this->actingAs(makeUser($role))->get('/admin/users')->assertRedirect();
})->with(['commercial', 'support', 'visitor']);

test('admins reach the administration area', function (string $path) {
    $this->actingAs(makeUser('admin'))->get($path)->assertOk();
})->with(['/admin/dashboard', '/admin/users', '/admin/settings', '/admin/audit-logs', '/admin/attribution-rules', '/admin/maintenance', '/admin/access-requests']);

test('support pages are restricted to the support role', function (string $role) {
    $this->actingAs(makeUser($role))->get('/support/dashboard')->assertForbidden();
})->with(['admin', 'commercial', 'visitor']);

test('a commercial only sees his own contacts and opportunities', function () {
    $hugo = makeUser('commercial');
    $ines = makeUser('commercial');
    $own = makeContact($hugo);
    $other = makeContact($ines);
    $otherOpportunity = makeOpportunity($other);

    $this->actingAs($hugo)->get("/contacts/{$own->id}")->assertOk();
    $this->actingAs($hugo)->get("/contacts/{$other->id}")->assertForbidden();
    $this->actingAs($hugo)->get("/contacts/{$other->id}/edit")->assertForbidden();
    $this->actingAs($hugo)->get("/opportunities/{$otherOpportunity->id}")->assertForbidden();
    $this->actingAs($hugo)->put("/opportunities/{$otherOpportunity->id}", ['titre' => 'Piraté'])->assertForbidden();
});

test('a visitor cannot change the stage of an opportunity', function () {
    $opportunity = makeOpportunity(makeContact(makeUser('commercial')));

    $this->actingAs(makeUser('visitor'))
        ->post("/opportunities/{$opportunity->id}/transition", ['stade' => 'perdu'])
        ->assertForbidden();

    expect($opportunity->fresh()->stade)->toBe('qualification');
});

test('a visitor cannot write on contacts or activities', function () {
    $contact = makeContact(makeUser('commercial'), ['statut' => 'qualifie']);
    $visitor = makeUser('visitor');

    $this->actingAs($visitor)->patch("/contacts/{$contact->id}/stage", ['statut' => 'perdu'])->assertForbidden();
    $this->actingAs($visitor)->post("/contacts/{$contact->id}/interaction", ['type' => 'appel'])->assertForbidden();
    $this->actingAs($visitor)->post('/activities', [
        'type' => 'note', 'description' => 'x', 'date_activite' => now()->toDateTimeString(),
        'parent_type' => 'contact', 'parent_id' => $contact->id,
    ])->assertForbidden();

    expect($contact->fresh()->statut)->toBe('qualifie');
    expect($contact->activities()->count())->toBe(0);
});

test('a commercial cannot edit, update or answer a ticket outside his scope', function () {
    $support = makeUser('support');
    $ticket = makeTicket($support, makeContact(makeUser('commercial')));
    $intruder = makeUser('commercial');

    $this->actingAs($intruder)->get("/tickets/{$ticket->id}/edit")->assertForbidden();
    $this->actingAs($intruder)->put("/tickets/{$ticket->id}", ['status' => 'closed'])->assertForbidden();
    $this->actingAs($intruder)->post("/tickets/{$ticket->id}/response", ['message' => 'x'])->assertForbidden();

    expect($ticket->fresh()->status)->toBe('new');
});

test('a commercial can manage tickets linked to his own contacts', function () {
    $commercial = makeUser('commercial');
    $ticket = makeTicket(makeUser('support'), makeContact($commercial));

    $this->actingAs($commercial)->get("/tickets/{$ticket->id}/edit")->assertOk();
    $this->actingAs($commercial)->put("/tickets/{$ticket->id}", ['status' => 'in_progress'])->assertRedirect();

    expect($ticket->fresh()->status)->toBe('in_progress');
});
