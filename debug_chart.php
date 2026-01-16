<?php

use Illuminate\Support\Facades\DB;
use App\Models\Opportunity;
use Carbon\Carbon;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "--- DEBUG OPPORTUNITY 'BTP' ---\n";
$opp = Opportunity::where('titre', 'like', '%BTP%')->first();
if ($opp) {
    echo "ID: " . $opp->id . "\n";
    echo "Titre: " . $opp->titre . "\n";
    echo "Stade: " . $opp->stade . "\n";
    echo "Montant: " . $opp->montant_estime . "\n";
    echo "Created At: " . $opp->created_at . "\n";
    echo "Month: " . ($opp->created_at ? $opp->created_at->format('Y-m') : 'NULL') . "\n";
} else {
    echo "Opportunity 'BTP' NOT FOUND.\n";
}

echo "\n--- DEBUG CHART QUERY ---\n";
// Replicating DashboardController Logic
$rawTrend = Opportunity::select(
        DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
        DB::raw('sum(montant_estime) as total')
    )
    ->where('stade', 'gagne')
    ->where('created_at', '>=', now()->startOfMonth()->subMonths(5))
    ->groupBy('month')
    ->get();

echo "Query Result count: " . $rawTrend->count() . "\n";
foreach ($rawTrend as $item) {
    echo "Month: " . $item->month . " => Total: " . $item->total . "\n";
}

echo "\n--- DEBUG RAW SQL ---\n";
$query = Opportunity::select(
        DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
        DB::raw('sum(montant_estime) as total')
    )
    ->where('stade', 'gagne')
    ->where('created_at', '>=', now()->startOfMonth()->subMonths(5))
    ->groupBy('month');
echo $query->toSql();
echo "\nBindings: " . implode(', ', $query->getBindings()) . "\n";
