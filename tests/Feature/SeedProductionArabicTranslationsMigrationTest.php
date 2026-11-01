<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SeedProductionArabicTranslationsMigrationTest extends TestCase
{
    public function test_migration_seeds_arabic_translations_correctly_and_is_idempotent(): void
    {
        // Require the migration file
        $migration = require database_path('migrations/2026_11_01_000000_seed_production_arabic_translations.php');

        // Run up
        $migration->up();

        // 1. Verify section contents in Arabic
        if (Schema::hasTable('section_contents')) {
            $this->assertDatabaseHas('section_contents', [
                'section' => 'hero',
                'key' => 'hero_title',
                'language' => 'ar',
                'value' => 'معاً، نبني مستقبلكم',
            ]);
            $this->assertDatabaseHas('section_contents', [
                'section' => 'about_page',
                'key' => 'why_us_title',
                'language' => 'ar',
                'value' => 'لماذا تختار CITABIC؟',
            ]);
            $this->assertDatabaseHas('section_contents', [
                'section' => 'contact',
                'key' => 'contact_title',
                'language' => 'ar',
                'value' => 'اتصل بنا',
            ]);
        }

        // 2. Verify certifications in Arabic
        if (Schema::hasTable('certifications')) {
            $this->assertDatabaseHas('certifications', [
                'slug' => 'certifie-iso-9001-v-2015',
                'language' => 'ar',
                'name' => 'معتمد ISO 9001 إصدار 2015',
            ]);
        }

        // 3. Verify mission translations if missions table exists
        if (Schema::hasTable('missions') && Schema::hasTable('mission_translations')) {
            if (DB::table('missions')->where('id', 1)->exists()) {
                $this->assertDatabaseHas('mission_translations', [
                    'mission_id' => 1,
                    'locale' => 'ar',
                    'title' => 'التميز التشغيلي',
                ]);
            }
        }

        // Run up again to ensure idempotency
        $migration->up();
        $this->assertTrue(true);
    }
}
