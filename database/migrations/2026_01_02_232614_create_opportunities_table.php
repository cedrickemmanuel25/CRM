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
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commercial_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('contact_id')->constrained()->onDelete('cascade');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->decimal('montant_estime', 15, 2)->nullable();
            $table->enum('stade', ['prospection', 'qualification', 'proposition', 'negociation', 'gagne', 'perdu'])->default('prospection');
            $table->integer('probabilite')->default(0);
            $table->date('date_cloture_prev')->nullable();
            $table->string('statut')->default('actif'); // actif, archive
            $table->timestamps();

            $table->index('stade');
            $table->index('commercial_id');
            $table->index('date_cloture_prev');
            $table->index('statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
