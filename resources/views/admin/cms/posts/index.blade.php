@extends('admin.layouts.master')

@php
    use App\Enums\PostStatus;
@endphp

@section('title', 'Posts')

@section('content')
    <x-breadcrumb item="CMS" active="Posts"/>

    <div class="row">
        <div class="col-sm-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Manage Posts</h5>
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">Add Post</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Categories</th>
                                    <th>Published At</th>
                                    <th>Views</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                    <tr>
                                        <td>
                                            @if($post->featured_image)
                                                <img src="{{ $post->featured_image }}" alt="" style="height: 40px;">
                                            @else
                                                <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $post->title }}</strong>
                                        </td>
                                        <td>
                                            @php
                                                $status = $post->status instanceof PostStatus ? $post->status : PostStatus::tryFrom((string) $post->status);
                                                $statusClass = match ($status) {
                                                    PostStatus::Published => 'bg-light-success',
                                                    PostStatus::Draft => 'bg-light-warning',
                                                    PostStatus::Archived => 'bg-light-secondary',
                                                    default => 'bg-light-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }}">
                                                {{ $status?->label() ?? (string) $post->status }}
                                            </span>
                                        </td>
                                        <td>
                                            @foreach($post->categories as $category)
                                                <span class="badge bg-light-info">{{ $category->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $post->published_at ? $post->published_at->format('d M Y H:i') : '-' }}</td>
                                        <td>{{ $post->views }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-light-primary me-1">Edit</a>
                                            @if($post->status === PostStatus::Published)
                                                <form action="{{ route('admin.posts.unpublish', $post) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-light-warning me-1">
                                                        {{ __('admin.posts.actions.unpublish') }}
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.posts.publish', $post) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-light-success me-1">
                                                        {{ __('admin.posts.actions.publish') }}
                                                    </button>
                                                </form>
                                            @endif
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-light-danger"
                                                data-table-action="delete"
                                                data-url="{{ route('admin.posts.destroy', $post) }}"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
