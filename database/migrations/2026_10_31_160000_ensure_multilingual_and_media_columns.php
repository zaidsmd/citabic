<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations safely without data loss.
     */
    public function up(): void
    {
        // 1. Ensure citabic_references supports blocks and videos
        if (Schema::hasTable('citabic_references')) {
            Schema::table('citabic_references', function (Blueprint $table) {
                if (! Schema::hasColumn('citabic_references', 'blocks')) {
                    $table->json('blocks')->nullable()->after('items');
                }
                if (! Schema::hasColumn('citabic_references', 'videos')) {
                    $table->json('videos')->nullable()->after('blocks');
                }
            });
        }

        // 2. Ensure citabic_profiles has translations
        if (Schema::hasTable('citabic_profiles')) {
            Schema::table('citabic_profiles', function (Blueprint $table) {
                if (! Schema::hasColumn('citabic_profiles', 'translations')) {
                    $table->json('translations')->nullable();
                }
            });
        }

        // 3. Ensure citabic_processes has translations
        if (Schema::hasTable('citabic_processes')) {
            Schema::table('citabic_processes', function (Blueprint $table) {
                if (! Schema::hasColumn('citabic_processes', 'translations')) {
                    $table->json('translations')->nullable();
                }
            });
        }

        // 4. Ensure citabic_domains has icon and translations
        if (Schema::hasTable('citabic_domains')) {
            Schema::table('citabic_domains', function (Blueprint $table) {
                if (! Schema::hasColumn('citabic_domains', 'icon')) {
                    $table->string('icon')->nullable()->after('title');
                }
                if (! Schema::hasColumn('citabic_domains', 'translations')) {
                    $table->json('translations')->nullable();
                }
            });
        }

        // 5. Ensure citabic_figures has translations
        if (Schema::hasTable('citabic_figures')) {
            Schema::table('citabic_figures', function (Blueprint $table) {
                if (! Schema::hasColumn('citabic_figures', 'translations')) {
                    $table->json('translations')->nullable();
                }
            });
        }

        // 6. Ensure citabic_values has image and translations
        if (Schema::hasTable('citabic_values')) {
            Schema::table('citabic_values', function (Blueprint $table) {
                if (! Schema::hasColumn('citabic_values', 'image')) {
                    $table->string('image')->nullable()->after('text');
                }
                if (! Schema::hasColumn('citabic_values', 'translations')) {
                    $table->json('translations')->nullable();
                }
            });
        }

        // 7. Ensure company_infos value column is text
        if (Schema::hasTable('company_infos')) {
            Schema::table('company_infos', function (Blueprint $table) {
                if (Schema::hasColumn('company_infos', 'value')) {
                    $table->text('value')->nullable()->change();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('citabic_references')) {
            Schema::table('citabic_references', function (Blueprint $table) {
                if (Schema::hasColumn('citabic_references', 'videos')) {
                    $table->dropColumn('videos');
                }
            });
        }
    }
};
