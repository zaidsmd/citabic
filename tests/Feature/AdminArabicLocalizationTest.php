<?php

namespace Tests\Feature;

use App\Models\Certification;
use App\Models\CitabicDomain;
use App\Models\CitabicFigure;
use App\Models\CitabicProcess;
use App\Models\CitabicProfile;
use App\Models\CitabicValue;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class AdminArabicLocalizationTest extends TestCase
{
    private User $adminUser;

    private CitabicProfile $profile;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::findOrCreate('access admin panel');
        Permission::findOrCreate('manage cms content');

        $this->adminUser = User::factory()->create();
        $this->adminUser->givePermissionTo(['access admin panel', 'manage cms content']);

        $this->profile = CitabicProfile::firstOrCreate(
            ['name' => 'CITABIC'],
            [
                'company_created_at' => now(),
                'tagline' => 'Tagline',
                'status' => 'active',
            ]
        );
    }

    public function test_admin_can_update_domain_with_arabic(): void
    {
        $domain = CitabicDomain::create([
            'citabic_profile_id' => $this->profile->id,
            'title' => 'Génie Civil',
            'items' => ['Travaux de fondations'],
            'sort_order' => 1,
            'type' => 'company',
            'translations' => [
                'en' => ['title' => 'Civil Engineering', 'items' => ['Foundation works']],
            ],
        ]);

        $response = $this->actingAs($this->adminUser)->put(route('admin.domains.update', $domain), [
            'title' => 'Génie Civil FR',
            'items' => ['Fondation 1'],
            'en' => [
                'title' => 'Civil Engineering EN',
                'items' => ['Foundation 1 EN'],
            ],
            'ar' => [
                'title' => 'الهندسة المدنية',
                'items' => ['أشغال الأساسات'],
            ],
        ]);

        $response->assertRedirect(route('admin.domains.index'));

        $domain->refresh();
        $this->assertEquals('الهندسة المدنية', $domain->translations['ar']['title']);
        $this->assertEquals(['أشغال الأساسات'], $domain->translations['ar']['items']);
    }

    public function test_admin_can_update_value_with_arabic(): void
    {
        $value = CitabicValue::create([
            'citabic_profile_id' => $this->profile->id,
            'title' => 'Engagement',
            'text' => 'Description FR',
            'sort_order' => 1,
            'type' => 'company',
        ]);

        $response = $this->actingAs($this->adminUser)->put(route('admin.values.update', $value), [
            'title' => 'Engagement FR',
            'text' => 'Description FR updated',
            'en' => [
                'title' => 'Commitment',
                'text' => 'Description EN',
            ],
            'ar' => [
                'title' => 'الالتزام',
                'text' => 'وصف الالتزام بالعربية',
            ],
        ]);

        $response->assertRedirect(route('admin.values.index', ['type' => $value->type]));

        $value->refresh();
        $this->assertEquals('الالتزام', $value->translations['ar']['title']);
        $this->assertEquals('وصف الالتزام بالعربية', $value->translations['ar']['text']);
    }

    public function test_admin_can_update_figure_with_arabic(): void
    {
        $figure = CitabicFigure::create([
            'citabic_profile_id' => $this->profile->id,
            'label' => 'Collaborateurs',
            'value' => '70+',
            'sort_order' => 1,
            'type' => 'company',
        ]);

        $response = $this->actingAs($this->adminUser)->put(route('admin.figures.update', $figure), [
            'label' => 'Collaborateurs FR',
            'value' => '75+',
            'en' => ['label' => 'Employees EN'],
            'ar' => ['label' => 'مهنيون متخصصون'],
        ]);

        $response->assertRedirect(route('admin.figures.index'));

        $figure->refresh();
        $this->assertEquals('مهنيون متخصصون', $figure->translations['ar']['label']);
    }

    public function test_admin_can_update_process_with_arabic(): void
    {
        $process = CitabicProcess::create([
            'citabic_profile_id' => $this->profile->id,
            'title' => 'Pilotage',
            'description' => 'Description processus FR',
            'sort_order' => 1,
            'type' => 'company',
        ]);

        $response = $this->actingAs($this->adminUser)->put(route('admin.processes.update', $process), [
            'title' => 'Pilotage FR',
            'description' => 'Description FR',
            'en' => [
                'title' => 'Steering EN',
                'description' => 'Description EN',
            ],
            'ar' => [
                'title' => 'القيادة والتوجيه',
                'description' => 'رؤية واضحة وقيادة ديناميكية',
            ],
        ]);

        $response->assertRedirect(route('admin.processes.index'));

        $process->refresh();
        $this->assertEquals('القيادة والتوجيه', $process->translations['ar']['title']);
        $this->assertEquals('رؤية واضحة وقيادة ديناميكية', $process->translations['ar']['description']);
    }

    public function test_admin_can_save_certification_with_arabic(): void
    {
        $certFr = Certification::create([
            'slug' => 'iso-test',
            'name' => 'ISO FR',
            'language' => 'fr',
            'description' => 'Desc FR',
            'image' => 'certifications/test.jpg',
        ]);

        $response = $this->actingAs($this->adminUser)->put(route('admin.certifications.update', $certFr), [
            'name_fr' => 'ISO FR Updated',
            'description_fr' => 'Desc FR Updated',
            'name_en' => 'ISO EN',
            'description_en' => 'Desc EN',
            'name_ar' => 'معتمد أيزو',
            'description_ar' => 'شهادة نظام إدارة الجودة',
        ]);

        $response->assertRedirect(route('admin.certifications.index'));

        $certAr = Certification::where('slug', 'iso-fr-updated')->where('language', 'ar')->first();
        $this->assertNotNull($certAr);
        $this->assertEquals('معتمد أيزو', $certAr->name);
        $this->assertEquals('شهادة نظام إدارة الجودة', $certAr->description);
    }
}
