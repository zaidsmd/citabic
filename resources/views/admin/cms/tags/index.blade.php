@extends('admin.layouts.master')
@section('title', 'Tags')
@section('content')
    <x-breadcrumb item="CMS" active="Tags"/>
    <div class="row">
        <div class="col-sm-12">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Manage Tags</h5>
                    <a href="{{ route('admin.tags.create') }}" class="btn btn-primary btn-sm">Add Tag</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Posts</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tags as $tag)
                                    <tr>
                                        <td>{{ $tag->name }}</td>
                                        <td>{{ $tag->slug }}</td>
                                        <td>{{ $tag->posts_count }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-sm btn-light-primary me-1">Edit</a>
                                            <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No tags found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
