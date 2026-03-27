@extends('admin.layouts.master')

@php($title = $type === 'human_values' ? 'Human Values' : 'Values')

@section('title', $title)

@section('content')
    <x-breadcrumb item="CMS" active="{{ $title }}"/>

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
                    <h5>Manage {{ $title }}</h5>
                    <a href="{{ route('admin.values.create', ['type' => $type]) }}" class="btn btn-primary btn-sm">Add {{ $type === 'human_values' ? 'Human Value' : 'Value' }}</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Text</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($values as $item)
                                    <tr>
                                        <td>
                                            @if(!empty($item->image))
                                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->image) }}" alt="{{ $item->title }}" style="width: 72px; height: 72px; object-fit: cover;" class="rounded border">
                                            @else
                                                <span class="text-muted small">No image</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ Str::limit($item->text, 100) }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.values.edit', $item) }}" class="btn btn-sm btn-light-primary me-1">Edit</a>
                                            <form action="{{ route('admin.values.destroy', $item) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No items found.</td>
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
