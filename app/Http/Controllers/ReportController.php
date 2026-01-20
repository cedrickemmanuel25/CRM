<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opportunity;
use App\Models\Contact;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function exportCsv(Request $request)
    {
        $type = $request->query('type', 'opportunities');
        $filename = $type . '_' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($type) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for Excel UTF-8 compatibility
            fputs($file, "\xEF\xBB\xBF");

            if ($type === 'opportunities') {
                fputcsv($file, ['ID', 'Titre', 'Montant', 'Stade', 'Probabilité', 'Contact', 'Commercial', 'Date Création'], ';');
                
                $query = Opportunity::with(['contact', 'commercial']);

                if (auth()->user()->isCommercial()) {
                    $query->byCommercial(auth()->id());
                }

                $query->chunk(100, function($opportunities) use ($file) {
                    foreach ($opportunities as $opp) {
                        fputcsv($file, [
                            $opp->id,
                            $opp->titre,
                            $opp->montant_estime,
                            $opp->stade,
                            $opp->probabilite . '%',
                            $opp->contact ? $opp->contact->nom . ' ' . $opp->contact->prenom : 'N/A',
                            $opp->commercial ? $opp->commercial->name : 'Non assigné',
                            $opp->created_at->format('Y-m-d')
                        ], ';');
                    }
                });
            } elseif ($type === 'contacts') {
                // Columns matching the View: Contact, Entreprise, Coordonnées (Email, Phone), Source, Propriétaire, Création
                // We split Coordonnées into Email and Phone for utility
                fputcsv($file, ['Contact', 'Entreprise', 'Email', 'Téléphone', 'Source', 'Propriétaire', 'Création', 'Statut'], ';');

                $query = Contact::query()->with('owner');

                if (auth()->user()->isCommercial()) {
                    $query->ownedBy(auth()->id());
                }

                if (request('search')) {
                    $query->search(request('search'));
                }
                if (request('entreprise')) {
                    $query->where('entreprise', 'like', "%" . request('entreprise') . "%");
                }
                if (request('source')) {
                    $query->where('source', request('source'));
                }
                if (request('owner_id')) {
                    $query->where('user_id_owner', request('owner_id'));
                }
                if (request('date_from')) {
                    $query->whereDate('created_at', '>=', request('date_from'));
                }
                if (request('date_to')) {
                    $query->whereDate('created_at', '<=', request('date_to'));
                }

                $query->latest()->chunk(100, function($contacts) use ($file) {
                    foreach ($contacts as $contact) {
                        fputcsv($file, [
                            $contact->nom . ' ' . $contact->prenom,
                            $contact->entreprise,
                            $contact->email,
                            $contact->telephone,
                            $contact->source,
                            $contact->owner->name ?? 'N/A',
                            $contact->created_at->format('d/m/Y'),
                            $contact->statut
                        ], ';');
                    }
                });
            } elseif ($type === 'leads') {
                 fputcsv($file, ['ID', 'Nom', 'Prénom', 'Email', 'Téléphone', 'Entreprise', 'Statut', 'Date Création'], ';');
                 
                 $query = Contact::where('statut', 'lead');

                 if (auth()->user()->isCommercial()) {
                     $query->ownedBy(auth()->id());
                 }

                 $query->chunk(100, function($contacts) use ($file) {
                    foreach ($contacts as $contact) {
                        fputcsv($file, [
                            $contact->id,
                            $contact->nom,
                            $contact->prenom,
                            $contact->email,
                            $contact->telephone,
                            $contact->entreprise,
                            $contact->statut,
                            $contact->created_at->format('Y-m-d')
                        ], ';');
                    }
                 });
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function printStats()
    {
        $user = auth()->user();
        
        $oppQuery = Opportunity::query();
        $contactQuery = Contact::where('statut', 'lead');

        if ($user->isCommercial()) {
            $oppQuery->byCommercial($user->id);
            $contactQuery->ownedBy($user->id);
        }

        // Reuse Dashboard logic but focused on global stats for print
        $stats = [
             'pipeline_value' => (clone $oppQuery)->whereNotIn('stade', ['gagne', 'perdu'])->sum('montant_estime'),
             'won_count' => (clone $oppQuery)->where('stade', 'gagne')->count(),
             'lost_count' => (clone $oppQuery)->where('stade', 'perdu')->count(),
             'total_leads' => $contactQuery->count(),
             'date' => Carbon::now()->format('d/m/Y H:i'),
        ];
        
        return view('reports.print', compact('stats'));
    }
    public function supportTickets()
    {
        $tickets = Activity::whereIn('type', ['ticket', 'probleme', 'reclamation'])
            ->with(['parent', 'user'])
            ->latest()
            ->get();
            
        $contacts = Contact::orderBy('nom')->get();

        return view('support.tickets', compact('tickets', 'contacts'));
    }

    public function exportPdf(Request $request)
    {
        $type = $request->query('type', 'opportunities');
        $date = Carbon::now()->format('d/m/Y');
        $user = auth()->user();
        
        if ($type === 'opportunities') {
            $title = "Rapport des Opportunités - $date";
            $query = Opportunity::with(['contact', 'commercial']);
            if ($user->isCommercial()) {
                $query->byCommercial($user->id);
            }
            $data = $query->latest()->get();
            $view = 'reports.pdf_opportunities';
        } else {
            $title = "Rapport des Prospects - $date";
            $query = Contact::where('statut', 'lead');
            if ($user->isCommercial()) {
                $query->ownedBy($user->id);
            }
            $data = $query->latest()->get();
            $view = 'reports.pdf_leads';
        }

        $pdf = Pdf::loadView($view, [
            'title' => $title,
            'data' => $data,
            'date' => $date
        ]);

        return $pdf->download($type . '_' . Carbon::now()->format('Y-m-d') . '.pdf');
    }
}
