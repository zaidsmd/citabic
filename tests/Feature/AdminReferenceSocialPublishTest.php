<?php

namespace Tests\Feature;

use App\Models\CitabicProfile;
use App\Models\CitabicReference;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class AdminReferenceSocialPublishTest extends TestCase
{
    use DatabaseTransactions;

    private User $adminUser;

    private CitabicReference $reference;

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

        Permission::findOrCreate('access admin panel');
        Permission::findOrCreate('manage cms content');

        $this->adminUser = User::factory()->create(['is_admin' => true]);
        $this->adminUser->givePermissionTo(['access admin panel', 'manage cms content']);

        $this->reference = CitabicReference::create([
            'slug' => 'test-project-social-' . uniqid(),
            'title' => 'Tour CITABIC Casablanca',
            'client' => 'Groupe Finance',
            'summary' => 'Construction d\'un complexe moderne au cœur de Casablanca.',
            'description' => '<p>Détails du projet d\'ingénierie et de construction.</p>',
            'surface' => '12 000 m²',
            'budget' => '45 000 000 MAD',
            'image' => 'references/cover.jpg',
            'items' => [],
            'blocks' => [
                [
                    'type' => 'coverImage',
                    'content' => 'references/cover.jpg',
                ],
                [
                    'type' => 'heading',
                    'content' => 'Présentation générale',
                ],
            ],
            'sort_order' => 1,
        ]);
    }

    public function test_guest_cannot_access_reference_share_data(): void
    {
        $response = $this->get(route('admin.references.share-data', $this->reference));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_get_reference_share_data_json(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->getJson(route('admin.references.share-data', $this->reference));

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'title',
            'client',
            'url',
            'excerpt',
            'caption',
            'facebook_url',
            'linkedin_url',
        ]);

        $data = $response->json();
        $this->assertEquals($this->reference->title, $data['title']);
        $this->assertStringContainsString('facebook.com/sharer/sharer.php', $data['facebook_url']);
        $this->assertStringContainsString('linkedin.com/sharing/share-offsite', $data['linkedin_url']);
        $this->assertStringContainsString(urlencode(route('references.show', $this->reference->slug)), $data['facebook_url']);
        $this->assertStringContainsString(urlencode(route('references.show', $this->reference->slug)), $data['linkedin_url']);
        $this->assertStringContainsString('#CITABIC', $data['caption']);
    }

    public function test_admin_references_table_actions_include_facebook_and_linkedin_buttons(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.references.index'), [
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
            ]);

        $response->assertOk();
        $json = $response->json();
        $this->assertNotEmpty($json['data']);

        $actionsHtml = $json['data'][0]['actions'];
        $this->assertStringContainsString('facebook.com/sharer/sharer.php', $actionsHtml);
        $this->assertStringContainsString('linkedin.com/sharing/share-offsite', $actionsHtml);
        $this->assertStringContainsString('fa-facebook-f', $actionsHtml);
        $this->assertStringContainsString('fa-linkedin-in', $actionsHtml);
        $this->assertStringContainsString('btn-open-share-modal', $actionsHtml);
        $this->assertStringContainsString('data-caption=', $actionsHtml);
    }

    public function test_admin_edit_reference_page_renders_social_share_card(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.references.edit', $this->reference));

        $response->assertOk();
        $response->assertSee('facebook.com/sharer/sharer.php', false);
        $response->assertSee('linkedin.com/sharing/share-offsite', false);
        $response->assertSee('btnCopyEditCaption', false);
        $response->assertSee('editPageShareCaption', false);
    }

    public function test_public_reference_page_renders_open_graph_and_twitter_tags_for_social_sharing(): void
    {
        $response = $this->get(route('references.show', $this->reference->slug));

        $response->assertOk();
        $response->assertSee('<meta property="og:title" content="Tour CITABIC Casablanca | CITABIC">', false);
        $response->assertSee('<meta property="og:url" content="'.route('references.show', $this->reference->slug).'">', false);
        $response->assertSee('meta property="og:description"', false);
        $response->assertSee('Construction d&#039;un complexe moderne', false);
        $response->assertSee('meta property="og:image"', false);
        $response->assertSee('meta name="twitter:card"', false);
    }

    public function test_html_in_description_is_cleared_for_caption(): void
    {
        $htmlReference = CitabicReference::create([
            'slug' => 'html-project-' . uniqid(),
            'title' => 'Complexe Tertiaire',
            'client' => 'Bâtisseurs Réunis',
            'summary' => '',
            'description' => '<p>Bâtiment de <strong>haute technologie</strong> avec <a href="https://example.com">vue sur mer</a> &amp; finitions en marbre.&nbsp;&nbsp;</p><ul><li>Normes HQE</li><li>Énergie solaire</li></ul>',
            'surface' => '5 000 m²',
            'budget' => '15 000 000 MAD',
            'image' => 'references/test.jpg',
            'items' => [],
            'blocks' => [],
            'sort_order' => 2,
        ]);

        $caption = $htmlReference->getShareCaption();

        // Ensure all HTML tags are cleared
        $this->assertStringNotContainsString('<p>', $caption);
        $this->assertStringNotContainsString('</p>', $caption);
        $this->assertStringNotContainsString('<strong>', $caption);
        $this->assertStringNotContainsString('</strong>', $caption);
        $this->assertStringNotContainsString('<a', $caption);
        $this->assertStringNotContainsString('<ul>', $caption);
        $this->assertStringNotContainsString('<li>', $caption);

        // Ensure HTML entities are decoded to plain text
        $this->assertStringNotContainsString('&nbsp;', $caption);
        $this->assertStringNotContainsString('&amp;', $caption);
        $this->assertStringContainsString('haute technologie', $caption);
        $this->assertStringContainsString('& finitions en marbre', $caption);

        // Test API endpoint share-data returns clean caption
        $response = $this->actingAs($this->adminUser)
            ->getJson(route('admin.references.share-data', $htmlReference));

        $response->assertOk();
        $this->assertStringNotContainsString('<', $response->json('caption'));
        $this->assertStringNotContainsString('&amp;', $response->json('caption'));
    }

    public function test_html_in_summary_is_cleared_for_caption(): void
    {
        $htmlSummaryRef = CitabicReference::create([
            'slug' => 'html-summary-project-' . uniqid(),
            'title' => 'Usine Agroalimentaire',
            'client' => 'AgroCorp',
            'summary' => '<p>Résumé avec des <em>balises HTML</em> et du texte <strong>important</strong>.</p>',
            'description' => '<p>Description complète</p>',
            'surface' => '8 000 m²',
            'budget' => '25 000 000 MAD',
            'image' => 'references/test2.jpg',
            'items' => [],
            'blocks' => [],
            'sort_order' => 3,
        ]);

        $caption = $htmlSummaryRef->getShareCaption();

        $this->assertStringNotContainsString('<p>', $caption);
        $this->assertStringNotContainsString('<em>', $caption);
        $this->assertStringNotContainsString('<strong>', $caption);
        $this->assertStringContainsString('Résumé avec des balises HTML et du texte important', $caption);
    }
}
