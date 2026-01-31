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
        Schema::table('opportunities', function (Blueprint $table) {
            // Prospection
            $table->string('type_premier_contact')->nullable();
            $table->date('date_premier_contact')->nullable();
            $table->text('resume_premier_contact')->nullable();
            $table->string('niveau_interet')->nullable(); // faible, moyen, eleve

            // Qualification
            $table->string('pouvoir_decision')->nullable(); // decideur, influenceur, non_decideur
            $table->string('priorite_qualification')->nullable(); // basse, moyenne, haute
            $table->string('delai_projet_cat')->nullable(); // immediat, moins_3_mois, plus_3_mois

            // Proposition
            $table->string('type_proposition')->nullable(); // devis, offre_personnalisee
            $table->decimal('montant_propose', 15, 2)->nullable();
            $table->text('description_offre')->nullable();
            $table->string('document_offre')->nullable();

            // Négociation
            $table->text('points_negocies')->nullable();
            $table->text('objections_client')->nullable();
            $table->date('prochaine_action_date')->nullable();

            // Fermeture / Perte
            $table->string('motif_perte')->nullable();
            $table->text('commentaire_perte')->nullable();
            $table->date('relancer_plus_tard_date')->nullable();

            // Conversion
            $table->string('type_client')->nullable(); // particulier, entreprise
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropColumn([
                'type_premier_contact',
                'date_premier_contact',
                'resume_premier_contact',
                'niveau_interet',
                'pouvoir_decision',
                'priorite_qualification',
                'delai_projet_cat',
                'type_proposition',
                'montant_propose',
                'description_offre',
                'document_offre',
                'points_negocies',
                'objections_client',
                'prochaine_action_date',
                'motif_perte',
                'commentaire_perte',
                'relancer_plus_tard_date',
                'type_client',
            ]);
        });
    }
};
