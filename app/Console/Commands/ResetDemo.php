<?php

namespace App\Console\Commands;

use Database\Seeders\DemoSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ResetDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Réinitialise la base de la démonstration publique avec les données fictives du DemoSeeder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Garde-fous : jamais en dehors de l'instance de démonstration, jamais sur une autre base
        if (! config('demo.enabled')) {
            $this->error('Refusé : DEMO_MODE n\'est pas activé.');
            return self::FAILURE;
        }

        $connection = config('database.default');
        $database = (string) config("database.connections.{$connection}.database");
        $marker = (string) config('demo.database_marker');

        if ($marker === '' || ! str_contains(strtolower($database), strtolower($marker))) {
            $this->error("Refusé : le nom de la base « {$database} » ne contient pas « {$marker} ».");
            return self::FAILURE;
        }

        $this->call('migrate:fresh', ['--force' => true, '--seeder' => DemoSeeder::class, '--seed' => true]);

        // Fichiers éventuellement déposés avant l'activation du blocage des téléversements
        foreach (['avatars', 'contacts', 'tickets', 'opportunities', 'activites'] as $directory) {
            Storage::disk('public')->deleteDirectory($directory);
        }

        $this->call('cache:clear');
        $this->info('Démonstration réinitialisée.');

        return self::SUCCESS;
    }
}
