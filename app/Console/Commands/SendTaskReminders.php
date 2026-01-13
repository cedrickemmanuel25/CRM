<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskReminderNotification;
use Illuminate\Console\Command;

class SendTaskReminders extends Command
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
    protected $description = 'Send reminder notifications for tasks due tomorrow';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Searching for tasks due tomorrow...');

        // Get tasks due tomorrow that are not completed
        $tomorrow = now()->addDay()->startOfDay();
        $endOfTomorrow = now()->addDay()->endOfDay();

        $tasks = Task::whereBetween('due_date', [$tomorrow, $endOfTomorrow])
            ->where('statut', '!=', 'done')
            ->with('assignee')
            ->get();

        if ($tasks->isEmpty()) {
            $this->info('No tasks due tomorrow.');
            return 0;
        }

        $count = 0;
        foreach ($tasks as $task) {
            if ($task->assignee) {
                $task->assignee->notify(new TaskReminderNotification($task));
                $count++;
                $this->line("✓ Reminder sent to {$task->assignee->name} for task: {$task->titre}");
            }
        }

        $this->info("Successfully sent {$count} reminder(s).");
        return 0;
    }
}
