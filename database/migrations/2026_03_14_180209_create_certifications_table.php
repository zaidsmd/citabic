<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index();
            $table->string('name');
            $table->string('language')->default('en');
            $table->string('description');
            $table->string('image');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
