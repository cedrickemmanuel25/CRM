<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Convertir tous les anciens 'lead' en 'nouveau'
        DB::table('contacts')->where('statut', 'lead')->update(['statut' => 'nouveau']);

        // 2. S'assurer que le statut est nullable et sans défaut forcé
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('statut')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('statut')->default('lead')->change();
        });
        
        DB::table('contacts')->where('statut', 'nouveau')->update(['statut' => 'lead']);
    }
};
