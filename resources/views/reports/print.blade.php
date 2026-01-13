<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport CRM - {{ $stats['date'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-white p-8">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Rapport de Performance CRM</h1>
            <p class="text-gray-500">Généré le {{ $stats['date'] }}</p>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-8">
            <div class="border rounded-lg p-6 bg-gray-50">
                <h3 class="text-sm font-medium text-gray-500 uppercase">Valeur Pipeline (Ouvert)</h3>
                <p class="text-3xl font-bold text-indigo-600 mt-2">{{ number_format($stats['pipeline_value'], 0, ',', ' ') }} €</p>
            </div>
            <div class="border rounded-lg p-6 bg-gray-50">
                <h3 class="text-sm font-medium text-gray-500 uppercase">Total Leads Actifs</h3>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['total_leads'] }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-8">
            <div class="border rounded-lg p-6">
                <h3 class="text-sm font-medium text-gray-500 uppercase">Opportunités Gagnées</h3>
                <p class="text-2xl font-bold text-emerald-600 mt-2">{{ $stats['won_count'] }}</p>
            </div>
            <div class="border rounded-lg p-6">
                <h3 class="text-sm font-medium text-gray-500 uppercase">Opportunités Perdues</h3>
                <p class="text-2xl font-bold text-red-600 mt-2">{{ $stats['lost_count'] }}</p>
            </div>
        </div>

        <div class="mt-12 text-center no-print">
            <button onclick="window.print()" class="bg-indigo-600 text-white px-6 py-2 rounded shadow hover:bg-indigo-700">Imprimer ce rapport</button>
        </div>
        
        <div class="mt-8 border-t pt-4 text-center text-xs text-gray-400">
            {{ company_name() }} system generated report.
        </div>
    </div>
</body>
</html>
