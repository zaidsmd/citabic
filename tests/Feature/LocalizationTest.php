<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocalizationTest extends TestCase
{
    public function test_switching_to_arabic_sets_session_and_cookie(): void
    {
        $response = $this->get(route('locale.switch', 'ar'));

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('locale', 'ar');
        $response->assertCookie('locale', 'ar');
    }

    public function test_switching_to_unsupported_locale_aborts_404(): void
    {
        $response = $this->get(route('locale.switch', 'es'));

        $response->assertNotFound();
    }

    public function test_home_page_renders_arabic_and_rtl_when_locale_is_ar(): void
    {
        $response = $this->withSession(['locale' => 'ar'])->get('/');

        $response->assertOk();
        $response->assertSee('dir="rtl"', false);
        $response->assertSee('lang="ar"', false);
        $response->assertSee('bootstrap.rtl.min.css');
        $response->assertSee('Cairo');
        $response->assertSee(__('site.nav.home', [], 'ar'));
        $response->assertSee(__('site.nav.contact', [], 'ar'));
    }

    public function test_accept_language_header_automatically_detects_arabic(): void
    {
        $response = $this->withHeaders(['Accept-Language' => 'ar-MA,ar;q=0.9,fr;q=0.8'])->get('/');

        $response->assertOk();
        $response->assertSee('dir="rtl"', false);
        $response->assertSee('lang="ar"', false);
        $response->assertSessionHas('locale', 'ar');
    }

    public function test_locale_cookie_persists_arabic_preference(): void
    {
        $response = $this->withUnencryptedCookie('locale', 'ar')->get('/');

        $response->assertOk();
        $response->assertSee('dir="rtl"', false);
        $response->assertSee('lang="ar"', false);
    }

    public function test_all_public_pages_render_successfully_in_arabic(): void
    {
        $pages = [
            route('home'),
            route('company'),
            route('references.index'),
            route('blog.index'),
            route('contact'),
        ];

        foreach ($pages as $url) {
            $response = $this->withSession(['locale' => 'ar'])->get($url);
            $response->assertOk();
            $response->assertSee('dir="rtl"', false);
            $response->assertSee('lang="ar"', false);
        }
    }
}
