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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Polymorphic parent (Contact, Opportunity, etc.)
            $table->nullableMorphs('parent'); 
            
            $table->string('type'); // appel, email, reunion, note
            $table->text('description')->nullable(); 
            $table->text('contenu')->nullable(); // Keeping both for compatibility if needed, or stick to spec
            
            $table->dateTime('date_activite');
            $table->integer('duree')->nullable(); // Minutes
            $table->string('piece_jointe')->nullable();
            
            $table->string('statut')->default('termine'); // planifie, termine

            $table->timestamps();

            $table->index('user_id');
            $table->index('type');
            $table->index('date_activite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
