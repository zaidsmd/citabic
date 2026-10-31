<?php

use App\Models\CitabicProcess;
use App\Models\CitabicProfile;
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
            $processes = is_array($profile->processes) ? $profile->processes : [];
            $mission = is_array($profile->mission) ? $profile->mission : [];

            foreach ($processes as $index => $process_title) {
                CitabicProcess::create([
                    'citabic_profile_id' => $profile->id,
                    'title' => $process_title,
                    'description' => $mission[$index] ?? null,
                    'sort_order' => $index,
                ]);
            }
        }
    }

    public function down(): void
    {
        CitabicProcess::truncate();
    }
};
