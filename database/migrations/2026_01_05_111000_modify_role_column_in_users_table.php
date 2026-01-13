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
        Schema::table('users', function (Blueprint $table) {
            // Modify 'role' column to be string instead of enum to allow any role
            $table->string('role')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert back to enum if needed, though data might be truncated if 'visitor' exists
            // Ideally we shouldn't revert this if we want to keep visitors, so proceed with caution.
            // For now, let's keep it as string in down or try to revert to enum.
            // $table->enum('role', ['admin', 'commercial', 'support'])->change();
        });
    }
};
