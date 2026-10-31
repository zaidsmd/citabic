<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approach_item_translations', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('title');
            $table->text('description');
            $table->string('locale');
            $table->foreignId('approach_item_id')->constrained('approach_items')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['approach_item_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approach_item_translations');
    }
};
