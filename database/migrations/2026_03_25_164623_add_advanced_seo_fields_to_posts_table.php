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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('meta_keywords')->nullable()->after('meta_description');
            $table->string('focus_keyword')->nullable()->after('meta_keywords');
            $table->string('og_title')->nullable()->after('canonical_url');
            $table->text('og_description')->nullable()->after('og_title');
            $table->string('og_image')->nullable()->after('og_description');
            $table->string('twitter_title')->nullable()->after('og_image');
            $table->text('twitter_description')->nullable()->after('twitter_title');
            $table->string('twitter_image')->nullable()->after('twitter_description');
            $table->string('twitter_card')->default('summary_large_image')->after('twitter_image');
            $table->boolean('robots_index')->default(true)->after('twitter_card');
            $table->boolean('robots_follow')->default(true)->after('robots_index');
            $table->string('schema_type')->nullable()->after('robots_follow');
            $table->longText('schema_json')->nullable()->after('schema_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn([
                'meta_keywords',
                'focus_keyword',
                'og_title',
                'og_description',
                'og_image',
                'twitter_title',
                'twitter_description',
                'twitter_image',
                'twitter_card',
                'robots_index',
                'robots_follow',
                'schema_type',
                'schema_json',
            ]);
        });
    }
};
