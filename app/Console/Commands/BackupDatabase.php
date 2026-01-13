<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a daily backup of the database and clean old backups';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting database backup...');

        $filename = 'backup-' . date('Y-m-d-H-i-s') . '.sql';
        $path = storage_path('app/backups/' . $filename);

        // Ensure directory exists
        if (!file_exists(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        // Database configuration
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $database = config('database.connections.mysql.database');
        $host = config('database.connections.mysql.host');
        
        // Build command (using mysqldump from PATH)
        // Note: Check if password is set to avoid empty parameter issues
        $passwordArg = $password ? "--password=\"$password\"" : "";
        
        // Use proper quoting for Windows vs Linux if needed, simpler approach first
        $command = "mysqldump --user=\"$username\" $passwordArg --host=\"$host\" \"$database\" > \"$path\"";

        $this->info("Executing: mysqldump for $database");

        try {
            // Using shell_exec for simplicity with redirection
            // For production, Process with pipe is better but redirection `>` is shell feature
            $output = null;
            $resultCode = null;
            exec($command, $output, $resultCode);

            if ($resultCode !== 0) {
                $this->error('Backup failed. Check if mysqldump is installed and in PATH.');
                \Log::error("Backup failed with code $resultCode. Command: $command");
                return 1;
            }

            $this->info("Backup created successfully: $filename");
            
            // Retention Policy (30 days)
            $this->cleanOldBackups();

        } catch (\Exception $e) {
            $this->error('Backup failed: ' . $e->getMessage());
            \Log::error('Backup exception: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    private function cleanOldBackups()
    {
        $this->info('Cleaning old backups...');
        
        $files = glob(storage_path('app/backups/*.sql'));
        $now = time();
        $retentionPeriod = 30 * 24 * 60 * 60; // 30 days

        foreach ($files as $file) {
            if (is_file($file)) {
                if ($now - filemtime($file) >= $retentionPeriod) {
                    unlink($file);
                    $this->info("Deleted old backup: " . basename($file));
                }
            }
        }
    }
}
