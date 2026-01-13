<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskOverdueNotification;
use Illuminate\Console\Command;

class SendOverdueAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-overdue-alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send alerts for overdue tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Searching for overdue tasks...');

        // Get tasks that are overdue (due_date < now and not done)
        $tasks = Task::where('due_date', '<', now())
            ->where('statut', '!=', 'done')
            ->with('assignee')
            ->get();

        if ($tasks->isEmpty()) {
            $this->info('No overdue tasks found.');
            return 0;
        }

        $count = 0;
        foreach ($tasks as $task) {
            if ($task->assignee) {
                $task->assignee->notify(new TaskOverdueNotification($task));
                $count++;
                
                $daysOverdue = now()->diffInDays($task->due_date);
                $this->line("⚠ Alert sent to {$task->assignee->name} for overdue task ({$daysOverdue} days): {$task->titre}");
            }
        }

        $this->info("Successfully sent {$count} overdue alert(s).");
        return 0;
    }
}
