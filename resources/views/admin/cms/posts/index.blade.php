@extends('admin.layouts.master')

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
                                            <strong>{{ $post->title }}</strong><br>
                                            <small class="text-muted">{{ $post->slug }}</small>
                                        </td>
                                        <td>
                                            @if($post->status == 'published')
                                                <span class="badge bg-light-success">Published</span>
                                            @elseif($post->status == 'draft')
                                                <span class="badge bg-light-warning">Draft</span>
                                            @else
                                                <span class="badge bg-light-secondary">{{ ucfirst($post->status) }}</span>
                                            @endif
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
                                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
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
