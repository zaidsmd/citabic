<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class DatabaseSnapshotSeeder extends Seeder
{
    /**
     * Seed the application's database from a generated snapshot.
     */
    public function run(): void
    {
        $snapshotPath = database_path('seeders/data/database_snapshot.php');

        if (! file_exists($snapshotPath)) {
            throw new RuntimeException("Database snapshot file not found at [{$snapshotPath}].");
        }

        /** @var array<string, array<int, array<string, mixed>>> $snapshot */
        $snapshot = require $snapshotPath;

        DB::disableQueryLog();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            foreach (array_keys($snapshot) as $table) {
                DB::table($table)->truncate();
            }

            foreach ($snapshot as $table => $rows) {
                if ($rows === []) {
                    continue;
                }

                foreach (array_chunk($rows, 500) as $chunk) {
                    DB::table($table)->insert($chunk);
                }
            }
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
}
