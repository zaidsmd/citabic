<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public function up(): void
    {
        $permissions = [
            'access admin panel',
            'manage users',
            'manage blog posts',
            'manage blog comments',
            'manage contact submissions',
            'manage cms content',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $adminRole = Role::findOrCreate('admin', 'web');
        $blogEditorRole = Role::findOrCreate('blog editor', 'web');

        $adminRole->syncPermissions($permissions);
        $blogEditorRole->syncPermissions([
            'access admin panel',
            'manage blog posts',
            'manage blog comments',
        ]);

        $adminUsers = DB::table('users')
            ->where('is_admin', true)
            ->pluck('id');

        foreach ($adminUsers as $userId) {
            DB::table(config('permission.table_names.model_has_roles'))
                ->updateOrInsert(
                    [
                        'role_id' => $adminRole->id,
                        'model_type' => 'App\\Models\\User',
                        'model_id' => $userId,
                    ],
                    []
                );
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        $permissionNames = [
            'access admin panel',
            'manage users',
            'manage blog posts',
            'manage blog comments',
            'manage contact submissions',
            'manage cms content',
        ];

        Role::query()->whereIn('name', ['admin', 'blog editor'])->delete();
        Permission::query()->whereIn('name', $permissionNames)->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
};
