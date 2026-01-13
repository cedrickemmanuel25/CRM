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
                <th>Nom Complet</th>
                <th>Entreprise</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Source</th>
                <th>Date Création</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $lead)
            <tr>
                <td>{{ $lead->id }}</td>
                <td>{{ $lead->nom }} {{ $lead->prenom }}</td>
                <td>{{ $lead->entreprise }}</td>
                <td>{{ $lead->email }}</td>
                <td>{{ $lead->telephone }}</td>
                <td>{{ $lead->source ?? 'N/A' }}</td>
                <td>{{ $lead->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Généré par CRM PRO le {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
