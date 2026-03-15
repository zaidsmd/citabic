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
        Schema::table('citabic_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'intro',
                'market_context',
                'mission',
                'values',
                'human_values',
                'domains',
                'certifications',
                'figures',
                'partnerships',
                'compliance',
                'organization',
                'why_choose_us',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('citabic_profiles', function (Blueprint $table) {
            $table->json('intro')->nullable();
            $table->json('market_context')->nullable();
            $table->json('mission')->nullable();
            $table->json('values')->nullable();
            $table->json('human_values')->nullable();
            $table->json('domains')->nullable();
            $table->json('certifications')->nullable();
            $table->json('figures')->nullable();
            $table->json('partnerships')->nullable();
            $table->json('compliance')->nullable();
            $table->json('organization')->nullable();
            $table->json('why_choose_us')->nullable();
        });
    }
};
