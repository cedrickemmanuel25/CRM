<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Page d'accueil publique
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/test-public', function() {
    return "Public test works - " . date('H:i:s');
});

// Routes d'authentification (accessibles uniquement aux invités)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/request-access', [App\Http\Controllers\AccessRequestController::class, 'showForm'])->name('access.request');
    Route::post('/request-access', [App\Http\Controllers\AccessRequestController::class, 'submit'])->name('access.submit');
});

use App\Http\Controllers\ReportController;

// ... (existings imports)

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', [AuthController::class, 'logout']);
    
    // Rapports et Exports (Accessibles Admin, Commercial, Visiteur)
    Route::middleware('role:admin,commercial,visitor')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/csv', [ReportController::class, 'exportCsv'])->name('reports.export');
        Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
        Route::get('/reports/print', [ReportController::class, 'printStats'])->name('reports.print');
    });

    // Admin, Commercial & Support actions on contacts
    Route::middleware('role:admin,commercial,support')->group(function () {
        Route::post('/contacts/{contact}/activity', [App\Http\Controllers\ContactController::class, 'addActivity'])->name('contacts.addActivity');
        Route::post('/contacts/{contact}/note', [App\Http\Controllers\ContactController::class, 'storeNote'])->name('contacts.storeNote');
        Route::post('/contacts/{contact}/ticket', [App\Http\Controllers\ContactController::class, 'storeTicket'])->name('contacts.storeTicket');
    });

    // Admin & Commercial can manage contacts (creation, edit, delete, conversion)
    Route::middleware('role:admin,commercial')->group(function () {
        Route::get('/contacts/create', [App\Http\Controllers\ContactController::class, 'create'])->name('contacts.create');
        Route::post('/contacts', [App\Http\Controllers\ContactController::class, 'store'])->name('contacts.store');
        Route::get('/contacts/{contact}/edit', [App\Http\Controllers\ContactController::class, 'edit'])->name('contacts.edit');
        Route::put('/contacts/{contact}', [App\Http\Controllers\ContactController::class, 'update'])->name('contacts.update');
        Route::delete('/contacts/{contact}', [App\Http\Controllers\ContactController::class, 'destroy'])->name('contacts.destroy');
        Route::post('/contacts/{contact}/opportunity', [App\Http\Controllers\ContactController::class, 'addOpportunity'])->name('contacts.addOpportunity');
        Route::get('/contacts/{contact}/export', [App\Http\Controllers\ContactController::class, 'export'])->name('contacts.export');
        Route::post('/contacts/{contact}/convert', [App\Http\Controllers\ContactController::class, 'convertToOpportunity'])->name('contacts.convert');
    });
    
    Route::middleware('auth')->group(function () {
        Route::get('/contacts', [App\Http\Controllers\ContactController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/fetch', [App\Http\Controllers\ContactController::class, 'fetch'])->name('contacts.fetch');
        Route::get('/fix-encoding', function() {
            $contacts = \App\Models\Contact::all();
            $count = 0;
            $replacements = [
                'Ã©vÃ©nement' => 'Événement',
                'Ã©vÃ¨nement' => 'Événement', 
                'Ã‰vÃ©nement' => 'Événement',
                'Ã‰vÃ¨nement' => 'Événement',
                '6agn6' => 'Gagné',
                'GagnÃ©' => 'Gagné',
                'gagnÃ©' => 'gagné',
                'ProspÃ©' => 'Prospé',
                'prospÃ©' => 'prospé',
                'Ã©' => 'é',
                'Ã¨' => 'è',
                'Ãª' => 'ê',
                'Ã ' => 'à',
                'Ã§' => 'ç',
                'Ã‰' => 'É',
            ];
            
            foreach ($contacts as $contact) {
                $changed = false;
                foreach (['source', 'statut', 'nom', 'prenom', 'entreprise'] as $field) {
                    if ($contact->$field) {
                        $newValue = str_replace(array_keys($replacements), array_values($replacements), $contact->$field);
                        if ($newValue !== $contact->$field) {
                            $contact->$field = $newValue;
                            $changed = true;
                        }
                    }
                }
                if ($changed) {
                    $contact->save();
                    $count++;
                }
            }
            return "Correction terminée. $count contacts mis à jour.";
        })->name('fix.encoding');
        Route::get('/contacts/{contact}', [App\Http\Controllers\ContactController::class, 'show'])->name('contacts.show');
        Route::patch('/contacts/{contact}/stage', [App\Http\Controllers\ContactController::class, 'updateStage'])->name('contacts.updateStage');
        Route::post('/contacts/{contact}/interaction', [App\Http\Controllers\ContactController::class, 'logInteraction'])->name('contacts.logInteraction');
    });

    // Opportunities Module
    Route::middleware('role:admin,commercial')->group(function () {
        Route::get('/opportunities/create', [App\Http\Controllers\OpportunityController::class, 'create'])->name('opportunities.create');
        Route::post('/opportunities', [App\Http\Controllers\OpportunityController::class, 'store'])->name('opportunities.store');
        Route::get('/opportunities/{opportunity}/edit', [App\Http\Controllers\OpportunityController::class, 'edit'])->name('opportunities.edit');
        Route::put('/opportunities/{opportunity}', [App\Http\Controllers\OpportunityController::class, 'update'])->name('opportunities.update');
        Route::patch('/opportunities/{opportunity}/stage', [App\Http\Controllers\OpportunityController::class, 'updateStage'])->name('opportunities.updateStage');
        Route::post('/opportunities/{opportunity}/mark-won', [App\Http\Controllers\OpportunityController::class, 'markAsWon'])->name('opportunities.markWon');
        Route::post('/opportunities/{opportunity}/mark-lost', [App\Http\Controllers\OpportunityController::class, 'markAsLost'])->name('opportunities.markLost');
        Route::delete('/opportunities/{opportunity}', [App\Http\Controllers\OpportunityController::class, 'destroy'])->name('opportunities.destroy');
    });
    
    // Routes de transition (Placées hors du middleware 'role' pour test, mais toujours sous 'auth')
    Route::post('/opportunities/{opportunity}/transition', [App\Http\Controllers\OpportunityController::class, 'processTransition'])->name('opportunities.processTransition');
    Route::get('/opportunities/{opportunity}/transition', function() {
        return redirect()->route('opportunities.index');
    });

    Route::get('/debug-routing-controller', [App\Http\Controllers\OpportunityController::class, 'getRoutingDiagnostic']);
    Route::get('/debug-routing-simple', function() { return "Simple routing works - " . now(); });

    // All roles can view opportunities (wildcard routes last)
    Route::get('/opportunities', [App\Http\Controllers\OpportunityController::class, 'index'])->name('opportunities.index');
    Route::get('/opportunities/{opportunity}', [App\Http\Controllers\OpportunityController::class, 'show'])->name('opportunities.show');


    // Activities Module
    Route::get('/activities', [App\Http\Controllers\ActivityController::class, 'index'])->name('activities.index');
    Route::post('/activities', [App\Http\Controllers\ActivityController::class, 'store'])->name('activities.store');

    // Tasks Module
    // Write access for Admin, Commercial, Support
    Route::middleware('role:admin,commercial,support')->group(function () {
        Route::resource('tasks', App\Http\Controllers\TaskController::class)->except(['index', 'show']);
    });

    // Tickets Module (Support focused)
    Route::middleware('role:admin,support,commercial')->group(function () {
        Route::resource('tickets', App\Http\Controllers\TicketController::class);
        Route::post('/tickets/{ticket}/response', [App\Http\Controllers\TicketController::class, 'addResponse'])->name('tickets.response');
    });

    // Read access for everyone (including Visitor)
    Route::middleware('auth')->group(function () {
        Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index'])->name('tasks.index');
        Route::get('/tasks/{task}', [App\Http\Controllers\TaskController::class, 'show'])->name('tasks.show');
        Route::get('/calendar', [App\Http\Controllers\TaskController::class, 'calendar'])->name('calendar');
    });

    // Admin Module
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Admin Profile
        Route::get('/profile', [App\Http\Controllers\AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [App\Http\Controllers\AdminProfileController::class, 'update'])->name('profile.update');
        
        // Users Management
        Route::resource('users', App\Http\Controllers\UserManagementController::class)->except(['create', 'edit', 'show']); 
        Route::post('users/{user}/reset-password', [App\Http\Controllers\UserManagementController::class, 'resetPassword'])->name('users.reset-password');

        // Settings
        Route::get('/settings', [App\Http\Controllers\AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [App\Http\Controllers\AdminController::class, 'updateSettings'])->name('settings.update');

        // Audit Logs (Using new controller)
        Route::get('/audit-logs', [App\Http\Controllers\AuditLogController::class, 'index'])->name('audit_logs.index');
        Route::get('/export', [App\Http\Controllers\AdminController::class, 'export'])->name('export');
        
        // Attribution Rules
        Route::resource('attribution-rules', App\Http\Controllers\AttributionRuleController::class)->except(['show']);

        // Maintenance & RGPD
        Route::get('/maintenance', [App\Http\Controllers\AdminController::class, 'maintenance'])->name('maintenance');
        Route::post('/backup', [App\Http\Controllers\AdminController::class, 'runBackup'])->name('backup.run');
        Route::post('/gdpr/export', [App\Http\Controllers\AdminController::class, 'exportGdpr'])->name('gdpr.export');
        Route::delete('/maintenance/cleanup', [App\Http\Controllers\AdminController::class, 'cleanup'])->name('maintenance.cleanup');
        
        // Access Requests Management
        Route::get('/access-requests/stats', [App\Http\Controllers\AccessRequestController::class, 'stats'])->name('access-requests.stats');
        Route::get('/access-requests', [App\Http\Controllers\AccessRequestController::class, 'index'])->name('access-requests.index');
        Route::post('/access-requests/{id}/approve', [App\Http\Controllers\AccessRequestController::class, 'approve'])->name('access-requests.approve');
        Route::post('/access-requests/{id}/reject', [App\Http\Controllers\AccessRequestController::class, 'reject'])->name('access-requests.reject');
    });
    // Dashboard principal avec redirection selon le rôle
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Dashboard Commercial
    Route::middleware('role:commercial')->group(function () {
        Route::get('/commercial/dashboard', [DashboardController::class, 'index'])->name('commercial.dashboard');
        
        // Autres routes commercial...
    });
    
    // Notifications Module
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/fetch', [App\Http\Controllers\NotificationController::class, 'fetch'])->name('notifications.fetch');
    Route::get('/notifications/read/{id?}', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markRead');
    Route::delete('/notifications/clear', [App\Http\Controllers\NotificationController::class, 'destroyAll'])->name('notifications.clear');
    Route::delete('/notifications/{id}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/profile/notifications', [App\Http\Controllers\NotificationController::class, 'settings'])->name('notifications.settings');
    Route::post('/profile/notifications', [App\Http\Controllers\NotificationController::class, 'updateSettings'])->name('notifications.settings.update');
    
    // Profile Module
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Dashboard Support
    Route::middleware('role:support')->group(function () {
        Route::get('/support/dashboard', [DashboardController::class, 'index'])->name('support.dashboard');
        Route::get('/support/tickets', [ReportController::class, 'supportTickets'])->name('support.tickets');
        Route::get('/support/reports', [App\Http\Controllers\SupportReportController::class, 'index'])->name('support.reports');
        Route::get('/support/reports/pdf', [App\Http\Controllers\SupportReportController::class, 'exportPdf'])->name('support.reports.pdf');
    });
});

