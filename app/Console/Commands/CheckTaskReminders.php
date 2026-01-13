<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Notifications\TaskReminder;
use Carbon\Carbon;

class CheckTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for tasks due tomorrow or overdue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for task reminders...');

        // 1. Reminders for tomorrow
        $tomorrow = Carbon::tomorrow();
        $tasksDueTomorrow = Task::whereDate('due_date', $tomorrow)
                                ->where('statut', '!=', 'done')
                                ->get();

        foreach ($tasksDueTomorrow as $task) {
            if ($task->assignee) {
                $task->assignee->notify(new TaskReminder($task));
                $this->info("Reminder sent to {$task->assignee->name} for task #{$task->id}");
            }
        }

        // 2. Reminders for overdue (e.g. 1 day overdue, just once logic would be better but keeping simple)
        // For now preventing spam, we only send for tomorrow.
        
        $this->info('Done.');
    }
}
