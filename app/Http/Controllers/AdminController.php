<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Models\Opportunity;
use App\Models\AuditLog;
use App\Models\Setting;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Dashboard Admin Global
     */
    /**
     * Dashboard Admin Global - NOW HANDLED BY DashboardController
     */
    // public function dashboard() { ... }

    /**
     * Liste des logs d'audit
     */
    public function auditLogs()
    {
        $logs = AuditLog::with('user')->latest()->paginate(20);
        return view('admin.audit', compact('logs'));
    }

    /**
     * Paramètres système
     */
    public function settings()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $notificationPreferences = \App\Models\NotificationPreference::whereNull('user_id')
            ->get()
            ->keyBy('event_type');
            
        return view('admin.settings', compact('settings', 'notificationPreferences'));
    }

    /**
     * Mise à jour des paramètres
     */
    public function updateSettings(Request $request)
    {
        $data = $request->except('_token');
        
        // Handle logo file upload
        if ($request->hasFile('company_logo')) {
            $logoFile = $request->file('company_logo');
            $logoPath = $logoFile->store('logos', 'public');
            
            Setting::updateOrCreate(
                ['key' => 'company_logo'],
                ['value' => $logoPath]
            );
            unset($data['company_logo']);
        }

        // Handle Notification Preferences
        $notificationEvents = [
            'contact_created', 'contact_updated', 'contact_deleted',
            'opportunity_created', 'opportunity_updated', 'opportunity_won', 'opportunity_lost',
            'task_created', 'task_completed', 'task_overdue',
            'user_created', 'error'
        ];

        foreach ($notificationEvents as $event) {
            $emailKey = "notif_{$event}_email";
            $pushKey = "notif_{$event}_push";

            \App\Models\NotificationPreference::updateOrCreate(
                ['user_id' => null, 'event_type' => $event],
                [
                    'email_enabled' => $request->has($emailKey),
                    'push_enabled' => $request->has($pushKey),
                ]
            );

            // Remove from data to not save in Settings table
            unset($data[$emailKey], $data[$pushKey]);
        }
        
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => (string) $value]
            );
        }

        return redirect()->back()->with('success', 'Paramètres mis à jour avec succès.');
    }

    /**
     * Export global des données
     */
    public function export()
    {
        // Logique d'export CSV simplifiée
        $filename = "crm_export_" . date('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        fputcsv($handle, ['ID', 'Nom', 'Email', 'Role']);
        $users = User::all();
        foreach ($users as $user) {
            fputcsv($handle, [$user->id, $user->name, $user->email, $user->role]);
        }
        fclose($handle);
        exit;
    }

    /**
     * Maintenance Page
     */
    public function maintenance()
    {
        return view('admin.maintenance');
    }

    /**
     * Run Manual Backup (JSON Dump)
     */
    public function runBackup()
    {
        $backup = [
            'users' => User::all(),
            'contacts' => \App\Models\Contact::all(),
            'opportunities' => Opportunity::all(),
            'tasks' => \App\Models\Task::all(),
            'activities' => Activity::all(),
            'tickets' => \App\Models\Ticket::all(),
            'settings' => Setting::all(),
            'generated_at' => now()->toDateTimeString(),
        ];

        $filename = 'backup_' . now()->format('Y-m-d_H-i-s') . '.json';
        
        return response()->streamDownload(function () use ($backup) {
            echo json_encode($backup, JSON_PRETTY_PRINT);
        }, $filename);
    }

    /**
     * Export GDPR Data for User
     */
    public function exportGdpr(Request $request)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);
        $user = User::findOrFail($request->user_id);

        $data = [
            'user_info' => $user->toArray(),
            'owned_contacts' => $user->contacts,
            'assigned_opportunities' => $user->opportunities,
            'assigned_tasks' => \App\Models\Task::where('assigned_to', $user->id)->get(),
            'created_activities' => $user->activities,
            'tickets' => $user->createdTickets,
            'export_date' => now()->toDateTimeString(),
        ];

        AuditLog::log('gdpr_export', $user, null, ['exported_by' => auth()->id()]);

        $filename = 'gdpr_export_' . $user->id . '_' . now()->format('Y-m-d') . '.json';

        return response()->streamDownload(function () use ($data) {
            echo json_encode($data, JSON_PRETTY_PRINT);
        }, $filename);
    }

    /**
     * Cleanup Soft Deleted Data
     */
    public function cleanup()
    {
        // Users
        $usersDeleted = User::onlyTrashed()->count();
        User::onlyTrashed()->forceDelete();

        // Contacts
        $contactsDeleted = \App\Models\Contact::onlyTrashed()->count();
        \App\Models\Contact::onlyTrashed()->forceDelete();

        AuditLog::log('system_cleanup', auth()->user(), null, [
            'users_purged' => $usersDeleted, 
            'contacts_purged' => $contactsDeleted
        ]);

        return redirect()->back()->with('success', "Nettoyage terminé. $usersDeleted utilisateurs et $contactsDeleted contacts supprimés définitivement.");
    }
}
