@extends('guest.layouts.app-template')

@section('title', __('site.blog.seo.category_title', ['name' => $category->name ?? ($filterName ?? '')]))
@section('meta_description', __('site.blog.seo.category_description', ['name' => $category->name ?? ($filterName ?? '')]))
@section('canonical_url', route('blog.category', $category->slug ?? ''))
@section('og_type', 'website')
@section('og_title', __('site.blog.seo.category_title', ['name' => $category->name ?? ($filterName ?? '')]))
@section('og_description', __('site.blog.seo.category_description', ['name' => $category->name ?? ($filterName ?? '')]))
@section('og_url', route('blog.category', $category->slug ?? ''))
@section('meta_robots', request()->filled('q') ? 'noindex,follow' : 'index,follow')

@section('structured_data')
    @php
        $categorySchema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => __('site.blog.seo.category_title', ['name' => $category->name ?? ($filterName ?? '')]),
            'description' => __('site.blog.seo.category_description', ['name' => $category->name ?? ($filterName ?? '')]),
            'url' => route('blog.category', $category->slug ?? ''),
            'about' => [
                '@type' => 'Thing',
                'name' => $category->name ?? ($filterName ?? ''),
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($categorySchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endsection

@section('content')
    @include('guest.pages.partials.blog-listing-content', [
        'pageTitle' => __('site.blog.listing.category_title', ['name' => $category->name ?? ($filterName ?? '')]),
        'activeFilterType' => 'category',
        'activeFilterLabel' => __('site.blog.listing.filter_category'),
        'activeFilterName' => $category->name ?? ($filterName ?? null),
        'activeFilterSlug' => $category->slug ?? null,
        'search' => $search ?? null,
        'postMeta' => $postMeta ?? collect(),
        'recentPosts' => $recentPosts ?? collect(),
        'popularCategories' => $popularCategories ?? collect(),
        'popularTags' => $popularTags ?? collect(),
    ])
@endsection
