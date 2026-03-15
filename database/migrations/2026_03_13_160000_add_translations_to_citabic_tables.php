<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citabic_profiles', function (Blueprint $table) {
            $table->json('translations')->nullable()->after('why_choose_us');
        });

        Schema::table('citabic_references', function (Blueprint $table) {
            $table->json('translations')->nullable()->after('items');
        });
    }

    public function down(): void
    {
        Schema::table('citabic_profiles', function (Blueprint $table) {
            $table->dropColumn('translations');
        });

        Schema::table('citabic_references', function (Blueprint $table) {
            $table->dropColumn('translations');
        });
    }
};
