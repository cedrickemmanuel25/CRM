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
            $table->string('nom')->nullable()->change();
            $table->string('prenom')->nullable()->change();
            $table->string('entreprise')->nullable()->change();
            $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            // Reverting nullable changes might be tricky if data is null, 
            // but for completeness we define it.
            // In practice, we might leave them nullable or handle data migration first.
            $table->string('nom')->nullable(false)->change();
            $table->string('prenom')->nullable(false)->change();
            // email and entreprise might have been nullable before depending on original migration?
            // Assuming original state was NOT NULL based on error.
        });
    }
};
