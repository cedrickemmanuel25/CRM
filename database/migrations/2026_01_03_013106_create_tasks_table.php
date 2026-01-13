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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->foreignId('assigned_to')->constrained('users')->onDelete('cascade');
            $table->dateTime('due_date')->nullable();
            
            $table->enum('statut', ['todo', 'in_progress', 'done'])->default('todo');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            
            // Polymorphic relation (Contact, Opportunity)
            $table->nullableMorphs('related');
            
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index('assigned_to');
            $table->index('due_date');
            $table->index('statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
