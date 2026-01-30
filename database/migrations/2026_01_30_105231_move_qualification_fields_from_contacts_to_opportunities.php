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
            $table->text('besoin')->nullable()->after('description');
            $table->decimal('budget_estime', 15, 2)->nullable()->after('besoin');
            $table->boolean('decisionnaire')->default(false)->after('budget_estime');
            $table->date('delai_projet')->nullable()->after('decisionnaire');
            $table->integer('score')->default(0)->after('delai_projet');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(['besoin', 'budget_estime', 'decisionnaire', 'delai_projet', 'score']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->text('besoin')->nullable()->after('poste');
            $table->decimal('budget_estime', 15, 2)->nullable()->after('besoin');
            $table->boolean('decisionnaire')->default(false)->after('budget_estime');
            $table->date('delai_projet')->nullable()->after('decisionnaire');
            $table->integer('score')->default(0)->after('delai_projet');
        });

        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropColumn(['besoin', 'budget_estime', 'decisionnaire', 'delai_projet', 'score']);
        });
    }
};
