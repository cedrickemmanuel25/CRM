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
        Schema::create('opportunity_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opportunity_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who changed it
            $table->string('old_stage')->nullable();
            $table->string('new_stage');
            $table->timestamp('changed_at')->useCurrent();
            $table->timestamps();

            $table->index('opportunity_id');
            $table->index('new_stage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunity_histories');
    }
};
