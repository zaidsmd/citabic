<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citabic_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tagline');
            $table->string('full_name');
            $table->string('legal_name');
            $table->string('legal_form');
            $table->string('capital');
            $table->text('head_office');
            $table->string('ice');
            $table->string('company_created_at');
            $table->string('rc');
            $table->string('status');
            $table->string('phone');
            $table->string('email');
            $table->json('intro');
            $table->json('market_context');
            $table->json('mission');
            $table->json('values');
            $table->json('human_values');
            $table->json('domains');
            $table->json('certifications');
            $table->longText('information_system');
            $table->json('figures');
            $table->json('partnerships');
            $table->json('compliance');
            $table->json('organization');
            $table->json('processes');
            $table->json('why_choose_us');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citabic_profiles');
    }
};
