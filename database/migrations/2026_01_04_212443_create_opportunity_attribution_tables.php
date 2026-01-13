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
        // 1. Add columns to 'opportunities'
        Schema::table('opportunities', function (Blueprint $table) {
            $table->string('attribution_mode')->default('manual')->after('commercial_id'); // 'manual' or 'auto'
            $table->timestamp('assigned_at')->nullable()->after('attribution_mode');
        });

        // 2. Create 'opportunity_attribution_history'
        Schema::create('opportunity_attribution_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opportunity_id')->constrained('opportunities')->onDelete('cascade');
            $table->foreignId('assigned_to')->constrained('users')->onDelete('cascade'); // The commercial
            $table->foreignId('assigned_by')->nullable()->constrained('users')->onDelete('set null'); // The admin (null if auto)
            $table->string('mode'); // 'manual' or 'auto'
            $table->text('reason')->nullable(); // e.g. "Rule: Source = Web"
            $table->timestamps();
        });

        // 3. Create 'attribution_rules'
        Schema::create('attribution_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('criteria_type'); // 'source', 'type', 'workload', 'amount'
            $table->string('criteria_value')->nullable(); // e.g. "Web", "Prospect" (null for workload)
            $table->foreignId('target_user_id')->nullable()->constrained('users')->onDelete('set null'); // Null if it's a "load balancing" rule without specific target
            $table->integer('priority')->default(0); // Higher executes first
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribution_rules');
        Schema::dropIfExists('opportunity_attribution_histories');
        
        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropColumn(['attribution_mode', 'assigned_at']);
        });
    }
};
