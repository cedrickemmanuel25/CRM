<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; }
        .title { font-size: 20px; font-weight: bold; color: #4f46e5; }
        .meta { text-align: right; margin-bottom: 20px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #f9fafb; border: 1px solid #e5e7eb; padding: 10px; text-align: left; font-weight: bold; }
        td { border: 1px solid #e5e7eb; padding: 10px; }
        .stade { text-transform: capitalize; }
        .montant { text-align: right; font-weight: bold; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $title }}</div>
    </div>
    <div class="meta">Date d'export : {{ $date }}</div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Client</th>
                <th>Commercial</th>
                <th>Stade</th>
                <th>Probabilité</th>
                <th>Montant Est.</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $opp)
            <tr>
                <td>{{ $opp->id }}</td>
                <td>{{ $opp->titre }}</td>
                <td>{{ $opp->contact ? $opp->contact->nom . ' ' . $opp->contact->prenom : 'N/A' }}</td>
                <td>{{ $opp->commercial ? $opp->commercial->name : 'Non assigné' }}</td>
                <td class="stade">{{ $opp->stade }}</td>
                <td>{{ $opp->probabilite }}%</td>
                <td class="montant">{{ number_format($opp->montant_estime, 2, ',', ' ') }} €</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Généré par CRM PRO le {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
