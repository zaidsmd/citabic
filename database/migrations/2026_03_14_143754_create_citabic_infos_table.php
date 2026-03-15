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
        Schema::create('citabic_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('citabic_profile_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // 'intro', 'market_context', 'mission', 'certifications', 'partnerships', 'compliance', 'organization', 'why_choose_us'
            $table->text('content');
            $table->integer('sort_order')->default(0);
            $table->json('translations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citabic_infos');
    }
};
