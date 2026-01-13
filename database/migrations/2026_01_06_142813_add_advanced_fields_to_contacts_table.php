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
            $table->json('alternative_emails')->nullable()->after('email');
            $table->json('alternative_telephones')->nullable()->after('telephone');
            $table->json('tags')->nullable()->after('poste');
            $table->text('notes_internes')->nullable()->after('tags');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $columns = ['alternative_emails', 'alternative_telephones', 'tags', 'notes_internes'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('contacts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
