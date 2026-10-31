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
        $profiles = \App\Models\CitabicProfile::all();

        foreach ($profiles as $profile) {
            // Migrate values
            foreach (['values', 'human_values'] as $type) {
                $items = is_array($profile->$type) ? $profile->$type : [];
                foreach ($items as $index => $item) {
                    \App\Models\CitabicValue::create([
                        'citabic_profile_id' => $profile->id,
                        'type' => $type,
                        'title' => $item['title'] ?? '',
                        'text' => $item['text'] ?? '',
                        'sort_order' => $index,
                    ]);
                }
            }

            // Migrate domains
            $domains = is_array($profile->domains) ? $profile->domains : [];
            foreach ($domains as $index => $domain) {
                \App\Models\CitabicDomain::create([
                    'citabic_profile_id' => $profile->id,
                    'title' => $domain['title'] ?? '',
                    'items' => $domain['items'] ?? [],
                    'sort_order' => $index,
                ]);
            }

            // Migrate figures
            $figures = is_array($profile->figures) ? $profile->figures : [];
            foreach ($figures as $index => $figure) {
                \App\Models\CitabicFigure::create([
                    'citabic_profile_id' => $profile->id,
                    'label' => $figure['label'] ?? '',
                    'value' => $figure['value'] ?? '',
                    'sort_order' => $index,
                ]);
            }

            // Migrate list-based infos
            $infoTypes = [
                'intro',
                'market_context',
                'mission',
                'certifications',
                'partnerships',
                'compliance',
                'organization',
                'why_choose_us'
            ];

            foreach ($infoTypes as $type) {
                $items = is_array($profile->$type) ? $profile->$type : [];
                foreach ($items as $index => $content) {
                    \App\Models\CitabicInfo::create([
                        'citabic_profile_id' => $profile->id,
                        'type' => $type,
                        'content' => $content,
                        'sort_order' => $index,
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        \App\Models\CitabicValue::truncate();
        \App\Models\CitabicDomain::truncate();
        \App\Models\CitabicFigure::truncate();
        \App\Models\CitabicInfo::truncate();
    }
};
