<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SupportReportController extends Controller
{
    /**
     * Afficher la page de rapports support
     */
    public function index(Request $request)
    {
        $period = $request->get('period', 'day'); // day, week, month
        
        $query = Ticket::with(['contact', 'assignee', 'creator']);
        
        // Filtrer selon la période
        switch ($period) {
            case 'day':
                $query->whereDate('created_at', today());
                $periodLabel = 'Aujourd\'hui';
                break;
            case 'week':
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                $periodLabel = 'Cette Semaine';
                break;
            case 'month':
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
                $periodLabel = 'Ce Mois';
                break;
            default:
                $query->whereDate('created_at', today());
                $periodLabel = 'Aujourd\'hui';
        }
        
        $tickets = $query->latest()->get();
        
        // Statistiques
        $stats = [
            'total' => $tickets->count(),
            'new' => $tickets->where('status', 'new')->count(),
            'in_progress' => $tickets->where('status', 'in_progress')->count(),
            'resolved' => $tickets->where('status', 'resolved')->count(),
            'urgent' => $tickets->where('priority', 'urgent')->count(),
            'high' => $tickets->where('priority', 'high')->count(),
            'medium' => $tickets->where('priority', 'medium')->count(),
            'low' => $tickets->where('priority', 'low')->count(),
        ];
        
        return view('support.reports', compact('tickets', 'stats', 'period', 'periodLabel'));
    }

    /**
     * Exporter le rapport en PDF
     */
    public function exportPdf(Request $request)
    {
        $period = $request->get('period', 'day');
        $date = Carbon::now()->format('d/m/Y');
        
        $query = Ticket::with(['contact', 'assignee', 'creator']);
        
        // Filtrer selon la période
        switch ($period) {
            case 'day':
                $query->whereDate('created_at', today());
                $periodLabel = 'Aujourd\'hui';
                $filename = 'rapport_tickets_' . Carbon::now()->format('Y-m-d') . '.pdf';
                break;
            case 'week':
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                $periodLabel = 'Cette Semaine';
                $filename = 'rapport_tickets_semaine_' . Carbon::now()->format('Y-W') . '.pdf';
                break;
            case 'month':
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
                $periodLabel = 'Ce Mois';
                $filename = 'rapport_tickets_mois_' . Carbon::now()->format('Y-m') . '.pdf';
                break;
            default:
                $query->whereDate('created_at', today());
                $periodLabel = 'Aujourd\'hui';
                $filename = 'rapport_tickets_' . Carbon::now()->format('Y-m-d') . '.pdf';
        }
        
        $tickets = $query->latest()->get();
        
        // Statistiques
        $stats = [
            'total' => $tickets->count(),
            'new' => $tickets->where('status', 'new')->count(),
            'in_progress' => $tickets->where('status', 'in_progress')->count(),
            'resolved' => $tickets->where('status', 'resolved')->count(),
            'urgent' => $tickets->where('priority', 'urgent')->count(),
            'high' => $tickets->where('priority', 'high')->count(),
            'medium' => $tickets->where('priority', 'medium')->count(),
            'low' => $tickets->where('priority', 'low')->count(),
        ];
        
        $title = "Rapport des Tickets Support - $periodLabel - $date";
        
        $pdf = Pdf::loadView('support.reports_pdf', [
            'title' => $title,
            'tickets' => $tickets,
            'stats' => $stats,
            'periodLabel' => $periodLabel,
            'date' => $date
        ]);
        
        return $pdf->download($filename);
    }
}
