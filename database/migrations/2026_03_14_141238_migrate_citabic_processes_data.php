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
            $processes = is_array($profile->processes) ? $profile->processes : [];
            $mission = is_array($profile->mission) ? $profile->mission : [];

            foreach ($processes as $index => $process_title) {
                \App\Models\CitabicProcess::create([
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
        \App\Models\CitabicProcess::truncate();
    }
};
