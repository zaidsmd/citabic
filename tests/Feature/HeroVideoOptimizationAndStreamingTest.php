<?php

namespace Tests\Feature;

use App\Enums\ContentKey;
use App\Enums\Section;
use App\Models\CitabicProfile;
use App\Models\SectionContent;
use App\Models\User;
use App\Services\VideoOptimizationService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class HeroVideoOptimizationAndStreamingTest extends TestCase
{
    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::findOrCreate('access admin panel');
        Permission::findOrCreate('manage cms content');

        $this->adminUser = User::factory()->create();
        $this->adminUser->givePermissionTo(['access admin panel', 'manage cms content']);

        CitabicProfile::firstOrCreate(
            ['name' => 'CITABIC'],
            [
                'company_created_at' => now(),
                'tagline' => 'Tagline',
                'status' => 'active',
            ]
        );
    }

    public function test_streaming_endpoint_returns_200_without_range_header(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('hero/test.mp4', str_repeat('A', 1000));

        $response = $this->get('/media/stream/hero/test.mp4');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'video/mp4');
        $response->assertHeader('Accept-Ranges', 'bytes');
        $response->assertHeader('Content-Length', '1000');
    }

    public function test_streaming_endpoint_returns_206_with_range_header(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('hero/test.mp4', str_repeat('B', 5000));

        $response = $this->withHeaders([
            'Range' => 'bytes=0-999',
        ])->get('/media/stream/hero/test.mp4');

        $response->assertStatus(206);
        $response->assertHeader('Content-Type', 'video/mp4');
        $response->assertHeader('Accept-Ranges', 'bytes');
        $response->assertHeader('Content-Range', 'bytes 0-999/5000');
        $response->assertHeader('Content-Length', '1000');
    }

    public function test_streaming_endpoint_rejects_path_traversal(): void
    {
        $response = $this->get('/media/stream/../secrets.mp4');
        $response->assertStatus(403);
    }

    public function test_streaming_endpoint_rejects_unauthorized_extensions(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('docs/file.php', '<?php echo "evil";');

        $response = $this->get('/media/stream/docs/file.php');
        $response->assertStatus(403);
    }

    public function test_streaming_endpoint_returns_404_when_video_not_found(): void
    {
        Storage::fake('public');
        $response = $this->get('/media/stream/hero/missing-video.mp4');
        $response->assertStatus(404);
    }

    public function test_streaming_endpoint_returns_416_on_unsatisfiable_range(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('hero/test.mp4', str_repeat('X', 500));

        $response = $this->withHeaders([
            'Range' => 'bytes=1000-2000',
        ])->get('/media/stream/hero/test.mp4');

        $response->assertStatus(416);
    }

    public function test_home_page_renders_hero_video_with_stream_and_poster(): void
    {
        Cache::flush();
        Storage::fake('public');
        $heroFilename = 'hero/test-hero-video.mp4';
        Storage::disk('public')->put($heroFilename, str_repeat('V', 1000));
        Storage::disk('public')->put('hero/test-hero-video-poster.webp', 'fake poster');

        SectionContent::updateOrCreate(
            ['section' => Section::HERO->value, 'key' => ContentKey::HERO_VIDEO->value],
            ['value' => $heroFilename, 'language' => 'fr']
        );

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('data-hero-video', false);
        $response->assertSee('data-playback-rate="0.7"', false);
        $response->assertSee('preload="auto"', false);
        $response->assertSee('media/stream/hero/test-hero-video.mp4', false);
    }

    public function test_video_optimization_service_detects_ffmpeg(): void
    {
        $service = app(VideoOptimizationService::class);
        $this->assertTrue($service->isAvailable());
    }

    public function test_admin_upload_video_returns_stream_and_poster_urls(): void
    {
        Storage::fake('public');

        $fakeVideo = UploadedFile::fake()->create('hero-sample.mp4', 500, 'video/mp4');

        $response = $this->actingAs($this->adminUser)
            ->postJson(route('admin.sections.upload-video'), [
                'video' => $fakeVideo,
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'path',
            'url',
            'stream_url',
            'poster_url',
            'webm_url',
        ]);
    }
}