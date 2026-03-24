<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\DomainController;
use App\Http\Controllers\Admin\FigureController;
use App\Http\Controllers\Admin\ProcessController;
use App\Http\Controllers\Admin\ValueController;
use App\Http\Controllers\CitabicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/locale/{locale}', function (Request $request, string $locale) {
    abort_unless(in_array($locale, config('localization.supported', ['fr', 'en']), true), 404);

    $request->session()->put('locale', $locale);

    return redirect()->back();
})->name('locale.switch');

Route::get('/', [CitabicController::class, 'home'])->name('home');
Route::get('/societe', [CitabicController::class, 'company'])->name('company');
Route::get('/expertises', [CitabicController::class, 'expertise'])->name('expertise');
Route::get('/references', [CitabicController::class, 'references'])->name('references.index');
Route::get('/references/{slug}', [CitabicController::class, 'reference'])->name('references.show');
Route::get('/contact', [CitabicController::class, 'contact'])->name('contact');
Route::post('/contact-submit', [CitabicController::class, 'submitContact'])->name('contact.submit');

Route::prefix('cc')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
});

Route::prefix('admins')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/', [CmsController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [CmsController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [CmsController::class, 'updateProfile'])->name('profile.update');
    Route::get('/references', [CmsController::class, 'references'])->name('references.index');
    Route::get('/references/create', [CmsController::class, 'createReference'])->name('references.create');
    Route::post('/references', [CmsController::class, 'storeReference'])->name('references.store');
    Route::get('/references/{reference}/edit', [CmsController::class, 'editReference'])->name('references.edit');
    Route::put('/references/{reference}', [CmsController::class, 'updateReference'])->name('references.update');
    Route::delete('/references/{reference}', [CmsController::class, 'destroyReference'])->name('references.destroy');

    Route::resource('certifications', \App\Http\Controllers\Admin\CertificationController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::get('company-info', [\App\Http\Controllers\Admin\CompanyInfoController::class, 'index'])->name('company-info.index');
    Route::put('company-info', [\App\Http\Controllers\Admin\CompanyInfoController::class, 'update'])->name('company-info.update');

    Route::get('sections',[\App\Http\Controllers\Admin\SectionContentController::class,'index'])->name('sections.index');
    Route::put('sections',[\App\Http\Controllers\Admin\SectionContentController::class,'update'])->name('sections.update');
    Route::post('sections/upload-image',[\App\Http\Controllers\Admin\SectionContentController::class,'uploadImage'])->name('sections.upload-image');
    Route::post('sections/upload-video',[\App\Http\Controllers\Admin\SectionContentController::class,'uploadVideo'])->name('sections.upload-video');

    Route::get('our-approach', [\App\Http\Controllers\Admin\OurApproachController::class, 'index'])->name('our-approach.index');
    Route::put('our-approach', [\App\Http\Controllers\Admin\OurApproachController::class, 'update'])->name('our-approach.update');

    Route::get('pages/about-us', [\App\Http\Controllers\Admin\AboutUsController::class, 'index'])->name('pages.about-us');
    Route::put('pages/about-us', [\App\Http\Controllers\Admin\AboutUsController::class, 'update'])->name('pages.about-us.update');
    Route::post('pages/about-us/upload-image', [\App\Http\Controllers\Admin\AboutUsController::class, 'uploadImage'])->name('pages.about-us.upload-image');
    Route::get('pages/contact', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('pages.contact');
    Route::put('pages/contact', [\App\Http\Controllers\Admin\ContactController::class, 'update'])->name('pages.contact.update');
    Route::post('pages/contact/upload-image', [\App\Http\Controllers\Admin\ContactController::class, 'uploadImage'])->name('pages.contact.upload-image');
    Route::get('missions', [\App\Http\Controllers\Admin\MissionController::class, 'index'])->name('missions.index');
    Route::get('missions/create', [\App\Http\Controllers\Admin\MissionController::class, 'create'])->name('missions.create');
    Route::post('missions', [\App\Http\Controllers\Admin\MissionController::class, 'store'])->name('missions.store');
    Route::get('missions/{mission}/edit', [\App\Http\Controllers\Admin\MissionController::class, 'edit'])->name('missions.edit');
    Route::put('missions/{mission}', [\App\Http\Controllers\Admin\MissionController::class, 'update'])->name('missions.update');
    Route::delete('missions/{mission}', [\App\Http\Controllers\Admin\MissionController::class, 'destroy'])->name('missions.destroy');
    Route::post('missions/upload-image', [\App\Http\Controllers\Admin\MissionController::class, 'uploadImage'])->name('missions.upload-image');
    Route::get('php-info',function (){
        phpinfo();
    });
    Route::resource('processes', ProcessController::class);
    Route::resource('values', ValueController::class);
    Route::post('domains/upload-image', [DomainController::class, 'uploadImage'])->name('domains.upload-image');
    Route::resource('domains', DomainController::class);
    Route::resource('figures', FigureController::class);
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);
    Route::post('posts/upload-featured-image', [\App\Http\Controllers\Admin\PostController::class, 'uploadFeaturedImage'])
        ->name('posts.upload-featured-image');
});

Route::get('/blog', [CitabicController::class, 'blog'])->name('blog.index');
Route::get('/blog/{slug}', [CitabicController::class, 'blogPost'])->name('blog.show');

Route::redirect('/about', '/societe')->name('about');
Route::redirect('/service', '/expertises')->name('service');
Route::redirect('/service-details', '/expertises')->name('service-details');
Route::redirect('/project', '/references')->name('project');
Route::redirect('/team', '/societe')->name('team');
Route::redirect('/team-details', '/societe')->name('team-details');
Route::redirect('/pricing', '/expertises')->name('pricing');
Route::redirect('/appointment', '/contact')->name('appointment');
Route::redirect('/faq', '/societe')->name('faq');
Route::redirect('/testimonial', '/references')->name('testimonial');
Route::redirect('/blog-details', '/blog')->name('blog-details');
Route::redirect('/shop', '/references')->name('shop');
Route::redirect('/shop-details', '/references')->name('shop-details');
Route::redirect('/cart', '/references')->name('cart');
Route::redirect('/checkout', '/references')->name('checkout');
Route::redirect('/wishlist', '/references')->name('wishlist');
Route::redirect('/error', '/')->name('error');
Route::get('/project-details', fn () => redirect()->route('references.show', 'unite-industrielle-pjlp'))->name('project-details');
