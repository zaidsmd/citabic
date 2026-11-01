<?php

namespace Tests\Feature;

use App\Http\Requests\Admin\UpdateAboutUsRequest;
use App\Models\CitabicProfile;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminAboutUsAuthorizationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        CitabicProfile::firstOrCreate(
            ['name' => 'CITABIC'],
            [
                'company_created_at' => now(),
                'tagline' => 'Tagline',
                'status' => 'active',
            ]
        );
    }

    public function test_user_is_admin_method(): void
    {
        $regularUser = User::factory()->create(['is_admin' => false]);
        $this->assertFalse($regularUser->isAdmin());

        $flagAdmin = User::factory()->create(['is_admin' => true]);
        $this->assertTrue($flagAdmin->isAdmin());

        Role::findOrCreate('admin', 'web');
        $roleAdmin = User::factory()->create(['is_admin' => false]);
        $roleAdmin->assignRole('admin');
        $this->assertTrue($roleAdmin->isAdmin());

        Permission::findOrCreate('access admin panel', 'web');
        $permAdmin = User::factory()->create(['is_admin' => false]);
        $permAdmin->givePermissionTo('access admin panel');
        $this->assertTrue($permAdmin->isAdmin());
    }

    public function test_update_about_us_request_authorizes_admin_and_denies_non_admin(): void
    {
        $request = new UpdateAboutUsRequest();

        // Guest
        $this->assertFalse($request->authorize());

        // Regular user
        $regularUser = User::factory()->create(['is_admin' => false]);
        $this->actingAs($regularUser);
        $this->assertFalse($request->authorize());

        // Admin via is_admin column
        $adminUser = User::factory()->create(['is_admin' => true]);
        $this->actingAs($adminUser);
        $this->assertTrue($request->authorize());
    }

    public function test_admin_can_update_about_us_without_method_error(): void
    {
        Permission::findOrCreate('access admin panel', 'web');
        Permission::findOrCreate('manage cms content', 'web');

        $admin = User::factory()->create(['is_admin' => true]);
        $admin->givePermissionTo(['access admin panel', 'manage cms content']);

        $response = $this->actingAs($admin)->put(route('admin.pages.about-us.update'), [
            'history' => 'Notre histoire mise à jour',
            'mission' => 'Notre mission',
            'vision' => 'Notre vision',
        ]);

        $this->assertNotEquals(500, $response->getStatusCode());
        $response->assertRedirect();
    }
}
