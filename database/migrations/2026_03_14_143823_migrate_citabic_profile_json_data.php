<?php

use App\Models\CitabicDomain;
use App\Models\CitabicFigure;
use App\Models\CitabicInfo;
use App\Models\CitabicProfile;
use App\Models\CitabicValue;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $profiles = CitabicProfile::all();

        foreach ($profiles as $profile) {
            // Migrate values
            foreach (['values', 'human_values'] as $type) {
                $items = is_array($profile->$type) ? $profile->$type : [];
                foreach ($items as $index => $item) {
                    CitabicValue::create([
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
                CitabicDomain::create([
                    'citabic_profile_id' => $profile->id,
                    'title' => $domain['title'] ?? '',
                    'items' => $domain['items'] ?? [],
                    'sort_order' => $index,
                ]);
            }

            // Migrate figures
            $figures = is_array($profile->figures) ? $profile->figures : [];
            foreach ($figures as $index => $figure) {
                CitabicFigure::create([
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
                'why_choose_us',
            ];

            foreach ($infoTypes as $type) {
                $items = is_array($profile->$type) ? $profile->$type : [];
                foreach ($items as $index => $content) {
                    CitabicInfo::create([
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
        CitabicValue::truncate();
        CitabicDomain::truncate();
        CitabicFigure::truncate();
        CitabicInfo::truncate();
    }
};
