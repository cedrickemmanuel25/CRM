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
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('statut')->default('nouveau')->change();
        });

        // Migrate existing data
        \DB::table('contacts')->where('statut', 'lead')->update(['statut' => 'nouveau']);
        \DB::table('contacts')->where('statut', 'prospect')->update(['statut' => 'qualifie']);
        \DB::table('contacts')->where('statut', 'inactif')->update(['statut' => 'perdu']);
        // 'client' remains 'client'
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
             // Reverting to string for simplicity, but pointing to old default
            $table->string('statut')->default('lead')->change();
        });
    }
};
