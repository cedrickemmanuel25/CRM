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
                
                Opportunity::with(['contact', 'commercial'])->chunk(100, function($opportunities) use ($file) {
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
                 
                 Contact::where('statut', 'lead')->chunk(100, function($contacts) use ($file) {
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
        // Reuse Dashboard logic but focused on global stats for print
        $stats = [
             'pipeline_value' => Opportunity::where('stade', '!=', 'gagne')->where('stade', '!=', 'perdu')->sum('montant_estime'),
             'won_count' => Opportunity::where('stade', 'gagne')->count(),
             'lost_count' => Opportunity::where('stade', 'perdu')->count(),
             'total_leads' => Contact::where('statut', 'lead')->count(),
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
        
        if ($type === 'opportunities') {
            $title = "Rapport des Opportunités - $date";
            $data = Opportunity::with(['contact', 'commercial'])->latest()->get();
            $view = 'reports.pdf_opportunities';
        } else {
            $title = "Rapport des Prospects - $date";
            $data = Contact::where('statut', 'lead')->latest()->get();
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
