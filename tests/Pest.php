<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function makeUser(string $role, array $attributes = []): App\Models\User
{
    return App\Models\User::factory()->create(array_merge(['role' => $role], $attributes));
}

function makeContact(App\Models\User $owner, array $attributes = []): App\Models\Contact
{
    return App\Models\Contact::create(array_merge([
        'user_id_owner' => $owner->id,
        'nom' => 'Durand',
        'prenom' => 'Élise',
        'email' => uniqid('contact') . '@example.com',
        'entreprise' => 'Atelier Boréal',
        'source' => 'LinkedIn',
    ], $attributes));
}

function makeOpportunity(App\Models\Contact $contact, array $attributes = []): App\Models\Opportunity
{
    return App\Models\Opportunity::create(array_merge([
        'commercial_id' => $contact->user_id_owner,
        'contact_id' => $contact->id,
        'titre' => 'Refonte du site',
        'montant_estime' => 10000,
        'stade' => 'qualification',
        'probabilite' => 30,
        'statut' => 'actif',
    ], $attributes));
}

function makeTicket(App\Models\User $creator, App\Models\Contact $contact, array $attributes = []): App\Models\Ticket
{
    return App\Models\Ticket::create(array_merge([
        'subject' => 'Erreur à l\'export',
        'description' => 'Description du ticket',
        'category' => 'technical',
        'priority' => 'high',
        'status' => 'new',
        'contact_id' => $contact->id,
        'user_id' => $creator->id,
    ], $attributes));
}
