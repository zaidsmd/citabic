@extends('guest.layouts.app-template')

@section('title', __('site.blog.seo.index_title'))
@section('meta_description', __('site.blog.seo.index_description'))
@section('canonical_url', route('blog.index'))
@section('og_type', 'website')
@section('og_title', __('site.blog.seo.index_title'))
@section('og_description', __('site.blog.seo.index_description'))
@section('og_url', route('blog.index'))
@section('meta_robots', request()->filled('q') ? 'noindex,follow' : 'index,follow')

@section('structured_data')
    @php
        $schemaPosts = $posts instanceof \Illuminate\Contracts\Pagination\Paginator
            ? collect($posts->items())
            : collect($posts ?? []);
        $itemList = [
            '@context' => 'https://schema.org',
            '@type' => 'Blog',
            'name' => __('site.blog.seo.index_title'),
            'description' => __('site.blog.seo.index_description'),
            'url' => route('blog.index'),
            'blogPost' => $schemaPosts->take(12)->map(fn (array $post): array => [
                '@type' => 'BlogPosting',
                'headline' => $post['title'] ?? '',
                'url' => route('blog.show', $post['slug'] ?? ''),
                'datePublished' => $post['published_at'] ?? null,
                'dateModified' => $post['updated_at'] ?? null,
            ])->values()->all(),
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($itemList, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endsection

@section('content')
    @include('guest.pages.partials.blog-listing-content', [
        'pageTitle' => __('site.blog.listing.title'),
        'activeFilterType' => null,
        'activeFilterLabel' => null,
        'activeFilterName' => null,
        'search' => $search ?? null,
        'postMeta' => $postMeta ?? collect(),
        'recentPosts' => $recentPosts ?? collect(),
        'popularCategories' => $popularCategories ?? collect(),
        'popularTags' => $popularTags ?? collect(),
    ])
@endsection
