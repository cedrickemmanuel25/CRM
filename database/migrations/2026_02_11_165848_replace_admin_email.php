<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remplacer l'ancien email par le nouveau s'il existe
        \Illuminate\Support\Facades\DB::table('users')
            ->where('email', 'courriel@ya-consulting.com')
            ->update([
                'email' => 'guehiphilippe@ya-consulting.com',
                'role' => 'admin'
            ]);

        // S'assurer que le nouvel email est bien admin
        \Illuminate\Support\Facades\DB::table('users')
            ->where('email', 'guehiphilippe@ya-consulting.com')
            ->update(['role' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::table('users')
            ->where('email', 'guehiphilippe@ya-consulting.com')
            ->update([
                'email' => 'courriel@ya-consulting.com'
            ]);
    }
};
