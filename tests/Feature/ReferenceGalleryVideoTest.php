<?php

namespace Tests\Feature;

use App\Models\CitabicReference;
use App\Models\User;
use Database\Seeders\CitabicSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class ReferenceGalleryVideoTest extends TestCase
{
    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::findOrCreate('access admin panel');
        Permission::findOrCreate('manage cms content');

        $this->adminUser = User::factory()->create();
        $this->adminUser->givePermissionTo(['access admin panel', 'manage cms content']);

        (new CitabicSeeder)->run();
    }

    public function test_reference_detail_page_renders_gallery_with_video_and_modal(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('references/sample-gallery.mp4', 'dummy video content');

        $reference = CitabicReference::updateOrCreate(
            ['slug' => 'test-project-with-video-gallery'],
            [
                'title' => 'Sample Project with Video Gallery',
                'client' => 'Client ACME',
                'surface' => '1500 m²',
                'budget' => '$1,000,000',
                'year' => 2026,
                'summary' => 'A short summary',
                'description' => 'A full description',
                'items' => [],
                'image' => 'guest/assets/img/project/project_1_1.jpg',
                'sort_order' => 1,
                'blocks' => [
                    [
                        'type' => 'coverImage',
                        'content' => 'guest/assets/img/project/project_1_1.jpg',
                    ],
                    [
                        'type' => 'heading',
                        'content' => 'Project Overview',
                    ],
                    [
                        'type' => 'gallery',
                        'images' => [
                            '/storage/references/sample-gallery.mp4',
                            'guest/assets/img/project/project_1_2.jpg',
                        ],
                    ],
                ],
                'translations' => [
                    'en' => [
                        'title' => 'Sample Project with Video Gallery EN',
                    ],
                ],
            ]
        );

        $response = $this->get(route('references.show', $reference->slug));

        $response->assertStatus(200);
        $response->assertSee('gallery-video-play-badge', false);
        $response->assertSee('popup-content', false);
        $response->assertSee('gallery-video-modal', false);
        $response->assertSee(route('media.stream', ['path' => 'references/sample-gallery.mp4']), false);
        $response->assertSee('popup-image', false);

        $reference->delete();
    }

    public function test_admin_upload_video_supports_references_folder(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('clip.mp4', 1024, 'video/mp4');

        $response = $this->actingAs($this->adminUser)->postJson(route('admin.sections.upload-video'), [
            'video' => $file,
            'folder' => 'references',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'path',
            'url',
            'stream_url',
            'poster_url',
        ]);

        $path = $response->json('path');
        $this->assertStringStartsWith('references/', $path);
        Storage::disk('public')->assertExists($path);
    }
}
