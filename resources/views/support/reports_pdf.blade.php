<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport Support - CRM</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #4f46e5; padding-bottom: 15px; }
        .title { font-size: 22px; font-weight: bold; color: #4f46e5; margin-bottom: 5px; }
        .subtitle { font-size: 14px; color: #666; }
        .meta { text-align: right; margin-bottom: 20px; color: #666; font-size: 10px; }
        .stats { display: table; width: 100%; margin-bottom: 25px; border-collapse: separate; border-spacing: 8px; }
        .stat-box { display: table-cell; background-color: #f9fafb; border: 1px solid #e5e7eb; padding: 12px; text-align: center; border-radius: 4px; }
        .stat-value { font-size: 20px; font-weight: bold; color: #4f46e5; }
        .stat-label { font-size: 10px; color: #666; margin-top: 5px; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 10px; }
        th { background-color: #4f46e5; color: white; border: 1px solid #4f46e5; padding: 8px; text-align: left; font-weight: bold; }
        td { border: 1px solid #e5e7eb; padding: 8px; }
        tr:nth-child(even) { background-color: #f9fafb; }
        .priority-urgent { background-color: #fee2e2; color: #991b1b; font-weight: bold; }
        .priority-high { background-color: #fed7aa; color: #9a3412; font-weight: bold; }
        .priority-medium { background-color: #dbeafe; color: #1e40af; }
        .priority-low { background-color: #f3f4f6; color: #374151; }
        .status-new { background-color: #dbeafe; color: #1e40af; }
        .status-in_progress { background-color: #fef3c7; color: #92400e; }
        .status-resolved { background-color: #d1fae5; color: #065f46; }
        .status-closed { background-color: #f3f4f6; color: #374151; }
        .badge { padding: 3px 8px; border-radius: 12px; font-size: 9px; font-weight: bold; text-transform: uppercase; display: inline-block; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 9px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 5px; margin-left: -20px; padding-left: 20px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Rapport des Tickets Support</div>
        <div class="subtitle">{{ $periodLabel }} - {{ $date }}</div>
    </div>
    
    <div class="meta">
        Généré le {{ now()->format('d/m/Y à H:i') }} par {{ auth()->user()->name }}
    </div>

    <!-- Statistiques -->
    <div class="stats">
        <div class="stat-box">
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total</div>
        </div>
        <div class="stat-box">
            <div class="stat-value" style="color: #3b82f6;">{{ $stats['new'] }}</div>
            <div class="stat-label">Nouveaux</div>
        </div>
        <div class="stat-box">
            <div class="stat-value" style="color: #f59e0b;">{{ $stats['in_progress'] }}</div>
            <div class="stat-label">En Cours</div>
        </div>
        <div class="stat-box">
            <div class="stat-value" style="color: #10b981;">{{ $stats['resolved'] }}</div>
            <div class="stat-label">Résolus</div>
        </div>
        <div class="stat-box">
            <div class="stat-value" style="color: #ef4444;">{{ $stats['urgent'] }}</div>
            <div class="stat-label">Urgents</div>
        </div>
    </div>

    <!-- Liste des tickets -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 25%;">Sujet</th>
                <th style="width: 15%;">Client</th>
                <th style="width: 12%;">Assigné à</th>
                <th style="width: 10%;">Priorité</th>
                <th style="width: 12%;">Statut</th>
                <th style="width: 10%;">Catégorie</th>
                <th style="width: 11%;">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $ticket)
            <tr>
                <td>{{ $ticket->id }}</td>
                <td><strong>{{ $ticket->subject }}</strong></td>
                <td>{{ $ticket->contact->nom_complet ?? 'Inconnu' }}</td>
                <td>{{ $ticket->assignee->name ?? 'Non assigné' }}</td>
                <td>
                    <span class="badge priority-{{ $ticket->priority }}">
                        {{ $ticket->priority }}
                    </span>
                </td>
                <td>
                    <span class="badge status-{{ $ticket->status }}">
                        {{ str_replace('_', ' ', $ticket->status) }}
                    </span>
                </td>
                <td>{{ $ticket->category ?? 'N/A' }}</td>
                <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px; color: #9ca3af;">
                    Aucun ticket trouvé pour cette période
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Répartition par priorité -->
    <div style="margin-top: 30px; page-break-inside: avoid;">
        <h3 style="font-size: 14px; color: #4f46e5; margin-bottom: 10px; border-bottom: 1px solid #e5e7eb; padding-bottom: 5px;">
            Répartition par Priorité
        </h3>
        <table style="width: 100%;">
            <tr>
                <td style="width: 25%;"><strong>Urgent:</strong> {{ $stats['urgent'] }}</td>
                <td style="width: 25%;"><strong>Haute:</strong> {{ $stats['high'] }}</td>
                <td style="width: 25%;"><strong>Moyenne:</strong> {{ $stats['medium'] }}</td>
                <td style="width: 25%;"><strong>Basse:</strong> {{ $stats['low'] }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Généré par Nexus CRM le {{ now()->format('d/m/Y à H:i') }} - Page {PAGENO} / {nbpg}
    </div>
</body>
</html>
