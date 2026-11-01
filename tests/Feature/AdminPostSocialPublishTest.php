<?php

namespace Tests\Feature;

use App\Enums\PostStatus;
use App\Models\CitabicProfile;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class AdminPostSocialPublishTest extends TestCase
{
    use DatabaseTransactions;

    private User $adminUser;

    private Post $post;

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
        Permission::findOrCreate('manage blog posts');

        $this->adminUser = User::factory()->create(['is_admin' => true]);
        $this->adminUser->givePermissionTo(['access admin panel', 'manage blog posts']);

        $this->post = Post::create([
            'title' => 'L\'Avenir de la Construction Durable au Maroc',
            'slug' => 'avenir-construction-durable-' . uniqid(),
            'excerpt' => 'Analyse approfondie des nouvelles approches d\'ingénierie verte et bas carbone.',
            'content' => '<p>Les matériaux écologiques et les normes HQE transforment les chantiers marocains modernes.</p>',
            'status' => PostStatus::Published,
            'published_at' => now(),
            'author_id' => $this->adminUser->id,
            'featured_image' => 'posts/sample.jpg',
            'translations' => [],
            'blocks' => [],
        ]);
    }

    public function test_guest_cannot_access_post_share_data(): void
    {
        $response = $this->get(route('admin.posts.share-data', $this->post));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_get_post_share_data_json(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->getJson(route('admin.posts.share-data', $this->post));

        $response->assertOk();
        $response->assertJsonStructure([
            'id',
            'title',
            'url',
            'excerpt',
            'caption',
            'facebook_url',
            'linkedin_url',
        ]);

        $data = $response->json();
        $this->assertEquals($this->post->title, $data['title']);
        $this->assertStringContainsString('facebook.com/sharer/sharer.php', $data['facebook_url']);
        $this->assertStringContainsString('linkedin.com/sharing/share-offsite', $data['linkedin_url']);
        $this->assertStringContainsString(urlencode(route('blog.show', $this->post->slug)), $data['facebook_url']);
        $this->assertStringContainsString(urlencode(route('blog.show', $this->post->slug)), $data['linkedin_url']);
        $this->assertStringContainsString('#CITABIC', $data['caption']);
        $this->assertStringContainsString('#Blog', $data['caption']);
    }

    public function test_admin_posts_table_actions_include_facebook_and_linkedin_buttons(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.posts.index'), [
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
        $this->assertStringContainsString('btn-open-post-share-modal', $actionsHtml);
        $this->assertStringContainsString('data-caption=', $actionsHtml);
    }

    public function test_admin_edit_post_page_renders_social_share_card(): void
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.posts.edit', $this->post));

        $response->assertOk();
        $response->assertSee('facebook.com/sharer/sharer.php', false);
        $response->assertSee('linkedin.com/sharing/share-offsite', false);
        $response->assertSee('btnCopyEditCaption', false);
        $response->assertSee('editPageShareCaption', false);
    }

    public function test_public_blog_page_renders_open_graph_and_twitter_tags_for_social_sharing(): void
    {
        $response = $this->get(route('blog.show', $this->post->slug));

        $response->assertOk();
        $response->assertSee('<meta property="og:title" content="L&#039;Avenir de la Construction Durable au Maroc">', false);
        $response->assertSee('<meta property="og:url" content="'.route('blog.show', $this->post->slug).'">', false);
        $response->assertSee('meta property="og:description"', false);
        $response->assertSee('Analyse approfondie des nouvelles approches', false);
        $response->assertSee('meta property="og:image"', false);
        $response->assertSee('meta name="twitter:card"', false);
    }

    public function test_html_in_post_content_and_excerpt_is_cleared_for_caption(): void
    {
        $htmlPost = Post::create([
            'title' => 'Technologies Vertes & Efficacité',
            'slug' => 'tech-vertes-efficacite-' . uniqid(),
            'excerpt' => '<p>Innovations <strong>majeures</strong> dans le domaine du BTP avec <a href="https://example.com">matériaux composites</a> &amp; isolation thermique.&nbsp;&nbsp;</p><ul><li>Système hybride</li><li>Basse consommation</li></ul>',
            'content' => '<p>Texte complet avec <em>formatage riche</em>.</p>',
            'status' => PostStatus::Published,
            'published_at' => now(),
            'author_id' => $this->adminUser->id,
            'featured_image' => 'posts/sample2.jpg',
            'translations' => [],
            'blocks' => [],
        ]);

        $caption = $htmlPost->getShareCaption();

        // Ensure all HTML tags are cleared
        $this->assertStringNotContainsString('<p>', $caption);
        $this->assertStringNotContainsString('</p>', $caption);
        $this->assertStringNotContainsString('<strong>', $caption);
        $this->assertStringNotContainsString('</strong>', $caption);
        $this->assertStringNotContainsString('<a', $caption);
        $this->assertStringNotContainsString('<ul>', $caption);
        $this->assertStringNotContainsString('<li>', $caption);

        // Ensure entities are decoded to normal readable characters
        $this->assertStringContainsString('&', $caption);
        $this->assertStringNotContainsString('&amp;', $caption);
        $this->assertStringNotContainsString('&nbsp;', $caption);

        // Ensure clean excerpt contains expected plain text
        $this->assertStringContainsString('Innovations majeures dans le domaine du BTP', $caption);
        $this->assertStringContainsString('#CITABIC', $caption);
        $this->assertStringContainsString('#Blog', $caption);
    }
}
