@extends('guest.layouts.app-template')

@section('title', __('site.blog.seo.tag_title', ['name' => $tag->name ?? ($filterName ?? '')]))
@section('meta_description', __('site.blog.seo.tag_description', ['name' => $tag->name ?? ($filterName ?? '')]))
@section('canonical_url', route('blog.tag', $tag->slug ?? ''))
@section('og_type', 'website')
@section('og_title', __('site.blog.seo.tag_title', ['name' => $tag->name ?? ($filterName ?? '')]))
@section('og_description', __('site.blog.seo.tag_description', ['name' => $tag->name ?? ($filterName ?? '')]))
@section('og_url', route('blog.tag', $tag->slug ?? ''))
@section('meta_robots', request()->filled('q') ? 'noindex,follow' : 'index,follow')

@section('structured_data')
    @php
        $tagSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => __('site.blog.seo.tag_title', ['name' => $tag->name ?? ($filterName ?? '')]),
            'description' => __('site.blog.seo.tag_description', ['name' => $tag->name ?? ($filterName ?? '')]),
            'url' => route('blog.tag', $tag->slug ?? ''),
            'about' => [
                '@type' => 'Thing',
                'name' => $tag->name ?? ($filterName ?? ''),
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($tagSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endsection

@section('content')
    @include('guest.pages.partials.blog-listing-content', [
        'pageTitle' => __('site.blog.listing.tag_title', ['name' => $tag->name ?? ($filterName ?? '')]),
        'activeFilterType' => 'tag',
        'activeFilterLabel' => __('site.blog.listing.filter_tag'),
        'activeFilterName' => $tag->name ?? ($filterName ?? null),
        'activeFilterSlug' => $tag->slug ?? null,
        'search' => $search ?? null,
        'postMeta' => $postMeta ?? collect(),
        'recentPosts' => $recentPosts ?? collect(),
        'popularCategories' => $popularCategories ?? collect(),
        'popularTags' => $popularTags ?? collect(),
    ])
@endsection
