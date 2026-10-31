<?php

namespace Database\Seeders;

use App\Models\Mission;
use App\Models\MissionTranslation;
use Illuminate\Database\Seeder;

class MissionSeeder extends Seeder
{
    public function run(): void
    {
        $missions = [
            [
                'order' => 1,
                'translations' => [
                    'fr' => [
                        'title' => 'Excellence Opérationnelle',
                        'description' => 'Garantir la satisfaction de nos clients par des prestations BTP de haute qualité et des services intégrés sur mesure.',
                    ],
                    'en' => [
                        'title' => 'Operational Excellence',
                        'description' => 'Ensuring client satisfaction through high-quality construction and tailored integrated services.',
                    ],
                ],
            ],
            [
                'order' => 2,
                'translations' => [
                    'fr' => [
                        'title' => 'Standards Internationaux',
                        'description' => 'Une expertise certifiée et un management rigoureux appliqué à tous les niveaux de notre organisation.',
                    ],
                    'en' => [
                        'title' => 'International Standards',
                        'description' => 'Certified expertise and rigorous management systems applied across all levels of our organization.',
                    ],
                ],
            ],
            [
                'order' => 3,
                'translations' => [
                    'fr' => [
                        'title' => 'Offre Clé-en-Main',
                        'description' => 'Une gamme complète d\'activités (génie civil, façades, travaux divers) offrant une synergie optimale pour vos projets.',
                    ],
                    'en' => [
                        'title' => 'Turnkey Solutions',
                        'description' => 'A comprehensive range of activities (civil engineering, facades, various works) providing optimal synergy for your projects.',
                    ],
                ],
            ],
            [
                'order' => 4,
                'translations' => [
                    'fr' => [
                        'title' => 'Gestion & Durabilité',
                        'description' => 'Une gestion de projet optimale assurant la pérennité et la solidité de toutes nos réalisations.',
                    ],
                    'en' => [
                        'title' => 'Management & Durability',
                        'description' => 'Optimal project management ensuring the longevity and structural integrity of every realization.',
                    ],
                ],
            ],
        ];

        foreach ($missions as $missionData) {
            $mission = Mission::create([
                'order' => $missionData['order'],
                'background_image' => null,
                'icon' => null,
            ]);

            foreach ($missionData['translations'] as $locale => $translation) {
                MissionTranslation::create([
                    'mission_id' => $mission->id,
                    'locale' => $locale,
                    'title' => $translation['title'],
                    'description' => $translation['description'],
                ]);
            }
        }
    }
}
