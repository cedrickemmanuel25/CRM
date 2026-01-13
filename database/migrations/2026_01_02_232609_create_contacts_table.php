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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id_owner')->constrained('users')->onDelete('cascade');
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('entreprise')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('adresse')->nullable();
            $table->string('source')->nullable();
            $table->string('poste')->nullable(); // Kept for backward compat/completeness
            $table->enum('statut', ['lead', 'prospect', 'client', 'inactif'])->default('lead');
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index('user_id_owner');
            $table->index('email');
            $table->index('entreprise');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
