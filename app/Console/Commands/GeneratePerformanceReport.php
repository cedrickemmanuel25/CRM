<?php

namespace App\Console\Commands;

use App\Models\Opportunity;
use App\Models\User;
use App\Notifications\PerformanceSummaryNotification;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class GeneratePerformanceReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:performance-summary {period=daily}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and send commercial performance report to admins';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Generating {$this->argument('period')} performance report...");

        $startDate = $this->argument('period') === 'weekly' ? now()->startOfWeek() : now()->startOfDay();
        
        $totalRevenue = Opportunity::where('stade', 'gagne')
            ->where('updated_at', '>=', $startDate)
            ->sum('montant_estime');

        $wonCount = Opportunity::where('stade', 'gagne')
            ->where('updated_at', '>=', $startDate)
            ->count();

        $newLeads = Opportunity::where('created_at', '>=', $startDate)
            ->count();

        $stats = [
            'total_revenue' => $totalRevenue,
            'opportunities_won' => $wonCount,
            'new_leads' => $newLeads,
            'period' => $this->argument('period')
        ];

        NotificationService::send('performance_report', new PerformanceSummaryNotification($stats));

        $this->info("Performance report sent to administrators.");
        return 0;
    }
}
