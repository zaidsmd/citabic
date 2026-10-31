<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mission_translations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('locale');
            $table->foreignId('mission_id')->constrained('missions')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['mission_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mission_translations');
    }
};
